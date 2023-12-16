<?php

namespace WebPConvert\Convert\Converters;

use WebPConvert\Convert\Converters\AbstractConverter;
use WebPConvert\Convert\Converters\ConverterTraits\EncodingAutoTrait;
use WebPConvert\Convert\Exceptions\ConversionFailedException;
use WebPConvert\Convert\Exceptions\ConversionFailed\ConverterNotOperational\SystemRequirementsNotMetException;
use WebPConvert\Options\BooleanOption;
use WebPConvert\Options\IntegerOption;

//require '/home/rosell/.composer/vendor/autoload.php';

/**
 * Convert images to webp using Vips extension.
 *
 * @package    WebPConvert
 * @author     Bjørn Rosell <it@rosell.dk>
 * @since      Class available since Release 2.0.0
 */
class Vips extends AbstractConverter
{
    use EncodingAutoTrait;

    protected function getUnsupportedDefaultOptions()
    {
        return [
            'auto-filter',
            'size-in-percentage',
        ];
    }

    /**
    *  Get the options unique for this converter
     *
     *  @return  array  Array of options
     */
    public function getUniqueOptions($imageType)
    {
        $ssOption = new BooleanOption('smart-subsample', false);
        $ssOption->markDeprecated();
        return [
            $ssOption
        ];
    }

    /**
     * Check operationality of Vips converter.
     *
     * @throws SystemRequirementsNotMetException  if system requirements are not met
     */
    public function checkOperationality()
    {
        if (!extension_loaded('vips')) {
            throw new SystemRequirementsNotMetException('Required Vips extension is not available.');
        }

        if (!function_exists('vips_image_new_from_file')) {
            throw new SystemRequirementsNotMetException(
                'Vips extension seems to be installed, however something is not right: ' .
                'the function "vips_image_new_from_file" is not available.'
            );
        }

        if (!function_exists('vips_call')) {
            throw new SystemRequirementsNotMetException(
                'Vips extension seems to be installed, however something is not right: ' .
                'the function "vips_call" is not available.'
            );
        }

        if (!function_exists('vips_error_buffer')) {
            throw new SystemRequirementsNotMetException(
                'Vips extension seems to be installed, however something is not right: ' .
                'the function "vips_error_buffer" is not available.'
            );
        }


        vips_error_buffer(); // clear error buffer
        $result = vips_call('webpsave', null);
        if ($result === -1) {
            $message = vips_error_buffer();
            if (strpos($message, 'VipsOperation: class "webpsave" not found') === 0) {
                throw new SystemRequirementsNotMetException(
                    'Vips has not been compiled with webp support.'
                );
            }
        }
    }

    /**
     * Check if specific file is convertable with current converter / converter settings.
     *
     * @throws SystemRequirementsNotMetException  if Vips does not support image type
     */
    public function checkConvertability()
    {
        // It seems that png and jpeg are always supported by Vips
        // - so nothing needs to be done here

        if (function_exists('vips_version')) {
            $this->logLn('vipslib version: ' . vips_version());
        }
        $this->logLn('vips extension version: ' . phpversion('vips'));
    }

    /**
     * Create vips image resource from source file
     *
     * @throws  ConversionFailedException  if image resource cannot be created
     * @return  resource  vips image resource
     */
    private function createImageResource()
    {
        // We are currently using vips_image_new_from_file(), but we could consider
        // calling vips_jpegload / vips_pngload instead
        $result = /** @scrutinizer ignore-call */ vips_image_new_from_file($this->source, []);
        if ($result === -1) {
            /*throw new ConversionFailedException(
                'Failed creating new vips image from file: ' . $this->source
            );*/
            $message = /** @scrutinizer ignore-call */ vips_error_buffer();
            throw new ConversionFailedException($message);
        }

        if (!is_array($result)) {
            throw new ConversionFailedException(
                'vips_image_new_from_file did not return an array, which we expected'
            );
        }

        if (count($result) != 1) {
            throw new ConversionFailedException(
                'vips_image_new_from_file did not return an array of length 1 as we expected ' .
                '- length was: ' . count($result)
            );
        }

        $im = array_shift($result);
        return $im;
    }

    /**
     * Create parameters for webpsave
     *
     * @return  array  the parameters as an array
     */
    private function createParamsForVipsWebPSave()
    {
        // webpsave options are described here:
        // https://libvips.github.io/libvips/API/current/VipsForeignSave.html#vips-webpsave
        // near_lossless option is described here: https://github.com/libvips/libvips/pull/430

        // NOTE: When a new option becomes available, we MUST remember to add
        //       it to the array of possibly unsupported options in webpsave() !
        $options = [
            "Q" => $this->getCalculatedQuality(),
            'lossless' => ($this->options['encoding'] == 'lossless'),
            'strip' => $this->options['metadata'] == 'none',
        ];

        // Only set the following options if they differ from the default of vipslib
        // This ensures we do not get warning if that property isn't supported
        if ($this->options['smart-subsample'] !== false) {
            // PS: The smart-subsample option is now deprecated, as it turned out
            // it was corresponding to the "sharp-yuv" option (see #280)
            $options['smart_subsample'] = $this->options['smart-subsample'];
            $this->logLn(
                '*Note: the "smart-subsample" option is now deprecated. It turned out it corresponded to ' .
                'the general option "sharp-yuv". You should use "sharp-yuv" instead.*'
            );
        }
        if ($this->options['sharp-yuv'] !== false) {
            $options['smart_subsample'] = $this->options['sharp-yuv'];
        }

        if ($this->options['alpha-quality'] !== 100) {
            $options['alpha_q'] = $this->options['alpha-quality'];
        }

        if (!is_null($this->options['preset']) && ($this->options['preset'] != 'none')) {
            // preset. 0:default, 1:picture, 2:photo, 3:drawing, 4:icon, 5:text, 6:last
            $options['preset'] = array_search(
                $this->options['preset'],
                ['default', 'picture', 'photo', 'drawing', 'icon', 'text']
            );
        }
        if ($this->options['near-lossless'] !== 100) {
            if ($this->options['encoding'] == 'lossless') {
                // We only let near_lossless have effect when encoding is set to lossless
                // otherwise encoding=auto would not work as expected
                // Available in https://github.com/libvips/libvips/pull/430, merged 1 may 2016
                // seems it corresponds to release 8.4.2
                $options['near_lossless'] = true;

                // In Vips, the near-lossless value is controlled by Q.
                // this differs from how it is done in cwebp, where it is an integer.
                // We have chosen same option syntax as cwebp
                $options['Q'] = $this->options['near-lossless'];
            }
        }
        if ($this->options['method'] !== 4) {
            $options['reduction_effort'] = $this->options['method'];
        }

        return $options;
    }

    /**
     * Save as webp, using vips extension.
     *
     * Tries to save image resource as webp, using the supplied options.
     * Vips fails when a parameter is not supported, but we detect this and unset that parameter and try again
     * (recursively call itself until there is no more of these kind of errors).
     *
     * @param  resource  $im  A vips image resource to save
     * @throws  ConversionFailedException  if conversion fails.
     */
    private function webpsave($im, $options)
    {
        /** @scrutinizer ignore-call */ vips_error_buffer(); // clear error buffer
        $result = /** @scrutinizer ignore-call */ vips_call('webpsave', $im, $this->destination, $options);

        //trigger_error('test-warning', E_USER_WARNING);
        if ($result === -1) {
            $message = /** @scrutinizer ignore-call */ vips_error_buffer();

            $nameOfPropertyNotFound = '';
            if (preg_match("#no property named .(.*).#", $message, $matches)) {
                $nameOfPropertyNotFound = $matches[1];
            } elseif (preg_match("#(.*)\\sunsupported$#", $message, $matches)) {
                // Actually, I am not quite sure if this ever happens.
                // I got a "near_lossless unsupported" error message in a build, but perhaps it rather a warning
                if (in_array($matches[1], [
                    'lossless',
                    'alpha_q',
                    'near_lossless',
                    'smart_subsample',
                    'reduction_effort',
                    'preset'
                ])) {
                    $nameOfPropertyNotFound = $matches[1];
                }
            }

            if ($nameOfPropertyNotFound != '') {
                $msg = 'Note: Your version of vipslib does not support the "' .
                    $nameOfPropertyNotFound . '" property';

                switch ($nameOfPropertyNotFound) {
                    case 'alpha_q':
                        $msg .= ' (It was introduced in vips 8.4)';
                        break;
                    case 'near_lossless':
                        $msg .= ' (It was introduced in vips 8.4)';
                        break;
                    case 'smart_subsample':
                        $msg .= ' (its the vips equalent to the "sharp-yuv" option. It was introduced in vips 8.4)';
                        break;
                    case 'reduction_effort':
                        $msg .= ' (its the vips equalent to the "method" option. It was introduced in vips 8.8.0)';
                        break;
                    case 'preset':
                        $msg .= ' (It was introduced in vips 8.4)';
                        break;
                }
                $msg .= '. The option is ignored.';


                $this->logLn($msg, 'bold');

                unset($options[$nameOfPropertyNotFound]);
                $this->webpsave($im, $options);
            } else {
                throw new ConversionFailedException($message);
            }
        }
    }

    /**
     * Convert, using vips extension.
     *
     * Tries to create image resource and save it as webp using the calculated options.
     * PS: The Vips "webpsave" call fails when a parameter is not supported, but our webpsave() method
     * detect this and unset that parameter and try again (repeat until success).
     *
     * @throws  ConversionFailedException  if conversion fails.
     */
    protected function doActualConvert()
    {
/*
        $im = \Jcupitt\Vips\Image::newFromFile($this->source);
        //$im->writeToFile(__DIR__ . '/images/small-vips.webp', ["Q" => 10]);

        $im->webpsave($this->destination, [
            "Q" => 80,
            //'near_lossless' => true
        ]);
        return;*/

        $im = $this->createImageResource();
        $options = $this->createParamsForVipsWebPSave();
        $this->webpsave($im, $options);
    }
}
