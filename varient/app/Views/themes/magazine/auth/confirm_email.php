<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <div class="page-confirm">
                <?php if (!empty($success)): ?>
                    <div class="text-center mb-3">
                        <svg enable-background="new 0 0 512 512" height="64px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M256,6.998c-137.533,0-249,111.467-249,249c0,137.534,111.467,249,249,249s249-111.467,249-249  C505,118.464,393.533,6.998,256,6.998z M256,485.078c-126.309,0-229.08-102.771-229.08-229.081  c0-126.31,102.771-229.08,229.08-229.08c126.31,0,229.08,102.771,229.08,229.08C485.08,382.307,382.31,485.078,256,485.078z" fill="#5cb85c"/>
                            <polygon fill="#5cb85c" points="384.235,158.192 216.919,325.518 127.862,236.481 113.72,250.624 216.919,353.803 398.28,172.334"/>
                        </svg>
                    </div>
                    <h1 class="title">
                        <?= $success; ?>
                    </h1>
                    <a href="<?= langBaseUrl(); ?>" class="btn btn-md btn-custom m-t-15"><?= trans("btn_goto_home"); ?></a>
                <?php elseif (!empty($error)): ?>
                    <div class="text-center mb-3">
                        <svg enable-background="new 0 0 512 512" height="64px" viewBox="0 0 512 512" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M256,7C118.467,7,7,118.468,7,256.002C7,393.533,118.467,505,256,505s249-111.467,249-248.998  C505,118.468,393.533,7,256,7z M256,485.08c-126.31,0-229.08-102.771-229.08-229.078C26.92,129.692,129.69,26.92,256,26.92  c126.309,0,229.08,102.771,229.08,229.082C485.08,382.309,382.309,485.08,256,485.08z" fill="#dc3545"/>
                            <polygon fill="#dc3545" points="368.545,157.073 354.461,142.988 255.863,241.587 157.733,143.456 143.648,157.54 241.78,255.672   143.648,353.809 157.733,367.893 255.863,269.75 354.461,368.361 368.545,354.275 269.947,255.672 "/>
                        </svg>
                    </div>
                    <h1 class="title">
                        <?= $error; ?>
                    </h1>
                    <a href="<?= langBaseUrl(); ?>" class="btn btn-md btn-custom m-t-15"><?= trans("btn_goto_home"); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>