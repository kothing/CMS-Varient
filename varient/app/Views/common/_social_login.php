<?php if (!empty($generalSettings->facebook_app_id)): ?>
    <a href="<?= base_url('connect-with-facebook'); ?>" class="btn btn-social btn-social-facebook">
        <svg width="24" height="24" viewBox="0 0 14222 14222">
            <circle cx="7111" cy="7112" r="7111" fill="#ffffff"/>
            <path d="M9879 9168l315-2056H8222V5778c0-562 275-1111 1159-1111h897V2917s-814-139-1592-139c-1624 0-2686 984-2686 2767v1567H4194v2056h1806v4969c362 57 733 86 1111 86s749-30 1111-86V9168z" fill="#1877f2"/>
        </svg>
        <span><?= trans("connect_with_facebook"); ?></span>
    </a>
<?php endif;
if (!empty($generalSettings->google_client_id)): ?>
    <a href="<?= base_url('connect-with-google'); ?>" class="btn btn-social btn-social-google">
        <svg width="24" height="24" viewBox="0 0 128 128">
            <rect clip-rule="evenodd" fill="none" fill-rule="evenodd" height="128" width="128"/>
            <path clip-rule="evenodd" d="M27.585,64c0-4.157,0.69-8.143,1.923-11.881L7.938,35.648    C3.734,44.183,1.366,53.801,1.366,64c0,10.191,2.366,19.802,6.563,28.332l21.558-16.503C28.266,72.108,27.585,68.137,27.585,64" fill="#FBBC05" fill-rule="evenodd"/>
            <path clip-rule="evenodd" d="M65.457,26.182c9.031,0,17.188,3.2,23.597,8.436L107.698,16    C96.337,6.109,81.771,0,65.457,0C40.129,0,18.361,14.484,7.938,35.648l21.569,16.471C34.477,37.033,48.644,26.182,65.457,26.182" fill="#EA4335" fill-rule="evenodd"/>
            <path clip-rule="evenodd" d="M65.457,101.818c-16.812,0-30.979-10.851-35.949-25.937    L7.938,92.349C18.361,113.516,40.129,128,65.457,128c15.632,0,30.557-5.551,41.758-15.951L86.741,96.221    C80.964,99.86,73.689,101.818,65.457,101.818" fill="#34A853" fill-rule="evenodd"/>
            <path clip-rule="evenodd" d="M126.634,64c0-3.782-0.583-7.855-1.457-11.636H65.457v24.727    h34.376c-1.719,8.431-6.397,14.912-13.092,19.13l20.474,15.828C118.981,101.129,126.634,84.861,126.634,64" fill="#4285F4" fill-rule="evenodd"/>
        </svg>
        <span><?= trans("connect_with_google"); ?></span>
    </a>
<?php endif;
if (!empty($generalSettings->vk_app_id)): ?>
    <a href="<?= base_url('connect-with-vk'); ?>" class="btn btn-social btn-social-vk">
        <svg width="24" height="24" viewBox="0 0 24 24"><title/>
            <path d="M20,13c.24-.45,1.09-1.74,1.73-2.7C23.65,7.46,24,6.86,24,6.5a.5.5,0,0,0-.5-.5H19a.5.5,0,0,0-.49.41c-.25,1.38-3.49,5.34-4,5.59-.21,0-.5-.52-.5-1.5V6.28a1.18,1.18,0,0,0-.24-.93C13.43,5,12.92,5,11.5,5,8.92,5,8,5.77,8,6.5A.46.46,0,0,0,8.45,7S9,7.36,9,9.5A14.61,14.61,0,0,1,8.87,12C7.6,11.77,5.84,8.6,5,6.32A.5.5,0,0,0,4.5,6H.5A.5.5,0,0,0,0,6.59C.56,9.61,6.91,19,11,19h2c1.06,0,1.14-1.15,1.2-1.91s.11-1.09.3-1.09c.62,0,1.89,1.1,2.72,1.82S18.59,19,19,19h2.5c1.29,0,2.5,0,2.5-1,0-.38-.33-.82-2.23-3C21.14,14.31,20.29,13.36,20,13Z" style="fill:#ffffff"/>
        </svg>
        <span><?= trans("connect_with_vk"); ?></span>
    </a>
<?php endif;
if (!empty($generalSettings->facebook_app_id) || !empty($generalSettings->google_client_id) || !empty($generalSettings->vk_app_id)): ?>
    <p class="mt-3 mb-3 text-center text-muted"><span><?= $orText; ?></span></p>
<?php endif; ?>