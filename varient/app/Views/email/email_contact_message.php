<?= view('email/_header', ['subject' => $subject]); ?>
    <table role="presentation" class="main">
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?= trans("contact_message"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                <p style='text-align: center'>
                                    <?= trans("name"); ?>:&nbsp;<?= esc($message_name); ?><br>
                                    <?= trans("email"); ?>:&nbsp;<?= esc($message_email); ?><br><br>
                                    <?= esc($message_text); ?>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
<?= view('email/_footer'); ?>