<?php $socialArray = getSocialLinksArray();
$i = 0; ?>
<script type="application/ld+json">[{
"@context": "http://schema.org",
"@type": "Organization",
"url": "<?= base_url(); ?>",
"logo": {"@type": "ImageObject","width": 190,"height": 60,"url": "<?= getLogo(); ?>"}<?= !empty($socialArray) ? ',' : ''; ?>
<?php if (!empty($socialArray) && countItems($socialArray)): ?>
"sameAs": [<?php foreach ($socialArray as $item):if (isset($item['url'])): ?><?= $i != 0 ? ',' : ''; ?>"<?= escSls($item['url']); ?>"<?php endif;
$i++;endforeach; ?>]
<?php endif; ?>
},
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "url": "<?= base_url(); ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?= base_url(); ?>/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}]
</script>
<?php if (!empty($postJsonLD)):
$dateModified = $postJsonLD->updated_at;
if (empty($dateModified)) {
$dateModified = $postJsonLD->created_at;
}
if ($postJsonLD->post_type == 'video'):?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "VideoObject",
    "name": "<?= escSls($postJsonLD->title); ?>",
    "description": "<?= escSls($postJsonLD->summary); ?>",
    "thumbnailUrl": [
    "<?= getPostImage($postJsonLD, 'big'); ?>"
    ],
    "uploadDate": "<?= date(DATE_ISO8601, strtotime($postJsonLD->created_at)); ?>",
    "contentUrl": "<?= escSls($postJsonLD->video_url); ?>",
    "embedUrl": "<?= escSls($postJsonLD->video_embed_code); ?>"
}
</script>
<?php else: ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?= generatePostURL($postJsonLD); ?>"
    },
    "headline": "<?= escSls($postJsonLD->title); ?>",
    "name": "<?= escSls($postJsonLD->title); ?>",
    "articleSection": "<?= escSls($postJsonLD->category_name); ?>",
    "image": {
        "@type": "ImageObject",
        "url": "<?= getPostImage($postJsonLD, 'big'); ?>",
        "width": 750,
        "height": 500
    },
    "datePublished": "<?= date(DATE_ISO8601, strtotime($postJsonLD->created_at)); ?>",
    "dateModified": "<?= date(DATE_ISO8601, strtotime($dateModified)); ?>",
    "inLanguage": "<?= $activeLang->language_code; ?>",
    "keywords": "<?= $postJsonLD->keywords; ?>",
    "author": {
        "@type": "Person",
        "name": "<?= escSls($postJsonLD->author_username); ?>"
    },
    "publisher": {
    "@type": "Organization",
    "name": "<?= clrQuotes($baseSettings->application_name); ?>",
    "logo": {
        "@type": "ImageObject",
        "width": 190,
        "height": 60,
        "url": "<?= getLogo(); ?>"
    }
    },
    "description": "<?= escSls($postJsonLD->summary); ?>"
}
</script>
<?php endif;
endif;
if (!empty($category)):
if (!empty($parentCategory)):?>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "<?= escSls($parentCategory->name); ?>",
    "item": "<?= generateCategoryURL($parentCategory); ?>"
    },
    {
        "@type": "ListItem",
        "position": 2,
        "name": "<?= escSls($category->name); ?>",
        "item": "<?= generateCategoryURL($category); ?>"
    }]
}
</script>
<?php else: ?>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
    "@type": "ListItem",
    "position": 1,
    "name": "<?= escSls($category->name); ?>",
    "item": "<?= generateCategoryURL($category); ?>"
    }]
}
</script>
<?php endif;
endif; ?>