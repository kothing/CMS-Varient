<?= view('email/_header', ['subject' => $subject]); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?= trans("confirm_your_email"); ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: center'>
                                <?= trans("msg_confirmation_email"); ?><br>
                            </p>
                            <p style='text-align: center;margin-top: 30px;'>
                                <a href="<?= langBaseUrl('confirm-email?token=' . $token); ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: <?= $activeTheme->theme_color; ?>;color: #ffffff !important; border-radius: 3px;'>
                                    <?= trans("confirm_your_email"); ?>
                                </a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= view('email/_footer'); ?>