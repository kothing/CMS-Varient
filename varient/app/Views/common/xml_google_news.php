<?= '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<?= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'; ?>
<?php if (!empty($posts)):
    foreach ($posts as $post):
        $postUrl = base_url() . '/';
        if ($post->lang_id != $generalSettings->site_lang) {
            $postUrl .= esc($post->lang_short_form) . '/';
        }
        $postUrl .= $post->title_slug;
        $keywords = '';
        if (!empty($post->keywords)) {
            $arrayKeywords = explode(',', $post->keywords);
            if (!empty($arrayKeywords)) {
                $i = 0;
                foreach ($arrayKeywords as $str) {
                    if ($i <= 5) {
                        $str = trim($str ?? '');
                        $str = esc($str);
                        if (!empty($str)) {
                            if (empty($keywords)) {
                                $keywords = $str;
                            } else {
                                $keywords .= ', ' . $str;
                            }
                        }
                    }
                }
            }
        } ?>
        <url>
            <loc><?= esc($postUrl); ?></loc>
            <news:news>
                <news:publication>
                    <news:name><?= esc(removeSpecialCharacters($baseSettings->site_title)); ?></news:name>
                    <news:language><?= esc($post->lang_short_form); ?></news:language>
                </news:publication>
                <news:publication_date><?= date('c', strtotime($post->created_at)); ?></news:publication_date>
                <news:title><?= convertToXMLCharacter(xml_convert($post->title ?? '')); ?></news:title>
                <news:keywords><?= $keywords; ?></news:keywords>
            </news:news>
        </url>
    <?php endforeach;
endif; ?>
<?= '</urlset>'; ?>