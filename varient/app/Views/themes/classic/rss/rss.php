<?= '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:admin="http://webns.net/mvcb/"
     xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
     xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
    <title><?= convertToXMLCharacter(xml_convert($feedName ?? '')); ?></title>
    <link><?= $feedURL; ?></link>
    <description><?= convertToXMLCharacter(xml_convert($pageDescription ?? '')); ?></description>
    <dc:language><?= $pageLanguage; ?></dc:language>
    <dc:creator><?= $creatorEmail; ?></dc:creator>
    <dc:rights><?= convertToXMLCharacter(xml_convert($baseSettings->copyright ?? '')); ?></dc:rights>
<?php if(!empty($posts)):
foreach ($posts as $post): ?>
    <item>
        <title><?= convertToXMLCharacter(xml_convert($post->title ?? '')); ?></title>
        <link><?= generatePostURL($post); ?></link>
        <guid><?= generatePostURL($post); ?></guid>
        <description><![CDATA[ <?= $generalSettings->rss_content_type == 'content' ? $post->content : esc($post->summary); ?> ]]></description>
<?php if (!empty($post->image_url)):
$imagePath = $post->image_url;
if (strpos($imagePath, '?') !== false) {
    $imagePath = strtok($imagePath, "?");
}
$imagePath = strReplace('https://', 'http://', $imagePath ?? ''); ?>
        <enclosure url="<?= $imagePath; ?>" length="49398" type="image/jpeg"/>
<?php else:
    $imagePath = base_url($post->image_big);
if ($post->image_storage == 'aws_s3') {
    $imagePath = getAWSBaseURL() . $post->image_big;
}
if (!empty($imagePath)) {
$fileSize = @filesize(FCPATH . $post->image_big);
}
$imagePath = strReplace('https://', 'http://', $imagePath ?? '');
if(empty($fileSize) || $fileSize<1){
    $fileSize=49398;
}
if (!empty($fileSize)):?>
        <enclosure url="<?= $imagePath; ?>" length="<?= $fileSize; ?>" type="image/jpeg"/>
<?php endif;
endif; ?>
        <pubDate><?= date('r', strtotime($post->created_at)); ?></pubDate>
        <dc:creator><?= convertToXMLCharacter($post->author_username); ?></dc:creator>
    </item>
<?php endforeach;
endif;?>
    </channel>
</rss>