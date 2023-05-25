<?php $itemCount = 1;
if (!empty($sortedListItems)):
    foreach ($sortedListItems as $listItem): ?>
        <div class="ordered-list-item">
            <h3 class="title-post-item">
                <?php if ($post->show_item_numbers) {
                    echo $itemCount . '. ' . esc($listItem->title);
                } else {
                    echo esc($listItem->title);
                } ?>
            </h3>
            <?php if (!empty($listItem->image)):
                $imgBaseURL = getBaseURLByStorage($listItem->storage); ?>
                <div class="post-image">
                    <div class="post-image-inner">
                        <img src="<?= $imgBaseURL . $listItem->image_large; ?>" alt="<?= esc($listItem->title); ?>" class="img-fluid" width="856" height="570"/>
                        <figcaption class="img-description"><?= esc($listItem->image_description); ?></figcaption>
                    </div>
                </div>
            <?php endif; ?>
            <div class="post-text">
                <?= $listItem->content; ?>
            </div>
        </div>
        <?php $itemCount++;
    endforeach;
endif; ?>