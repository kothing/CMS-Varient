<?php namespace App\Models;

require APPPATH . 'ThirdParty/aws-sdk/vendor/autoload.php';

use CodeIgniter\Model;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class AwsModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->key = $this->generalSettings->aws_key;
        $this->secret = $this->generalSettings->aws_secret;
        $this->bucket = $this->generalSettings->aws_bucket;
        $this->region = $this->generalSettings->aws_region;

        $credentials = new \Aws\Credentials\Credentials($this->key, $this->secret);
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => $credentials
        ]);
    }

    //upload file
    public function uploadFile($path)
    {
        if (!empty($path) && file_exists(FCPATH . $path)) {
            $this->putFileObject($path, FCPATH . $path);
            @unlink(FCPATH . $path);
        }
    }

    //upload file direct
    public function uploadFileDirect($inputName, $path)
    {
        if (!empty($inputName) && !empty($path)) {
            $orjName = $_FILES[$inputName]['name'];
            $name = pathinfo($orjName, PATHINFO_FILENAME);
            $ext = pathinfo($orjName, PATHINFO_EXTENSION);
            $name = strSlug($name);
            if (empty($name)) {
                $name = generateToken();
            }
            $this->putObjectDirect($path . $name . '.' . $ext, $_FILES[$inputName]['tmp_name']);
            return ['orjName' => $orjName, 'path' => $path . $name . '.' . $ext];
        }
    }

    //put file object
    public function putFileObject($path)
    {
        if (!empty($path)) {
            $this->putObject($path, FCPATH . $path);
        }
    }

    //dowbload file
    function downloadFile($filePath)
    {
        $fileName = pathinfo($filePath, PATHINFO_BASENAME);
        header('Content-Disposition: attachment; filename=' . $fileName);
        readfile(getAWSBaseURL() . $filePath);
        exit();
    }

    //delete file
    public function deleteFile($path)
    {
        if (!empty($path)) {
            $this->deleteObject($path);
        }
    }

    //put object
    public function putObject($key, $tempPath)
    {
        if (file_exists($tempPath)) {
            try {
                $file = fopen($tempPath, 'r');
                $this->s3->putObject([
                    'Bucket' => $this->bucket,
                    'Key' => $key,
                    'Body' => $file,
                    'ACL' => 'public-read'
                ]);
                fclose($file);
                return true;
            } catch (S3Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }

    //put object direct
    public function putObjectDirect($key, $tempPath)
    {
        $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => $key,
            'Body' => fopen($tempPath, 'rb'),
            'ACL' => 'public-read'
        ]);
    }

    //delete object
    public function deleteObject($key)
    {
        if (!empty($key)) {
            try {
                $this->s3->deleteObject([
                    'Bucket' => $this->bucket,
                    'Key' => $key
                ]);
            } catch (S3Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }

}
