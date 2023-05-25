<link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-manager/fileicon.css'); ?>"/>
<?php $fileModel = new \App\Models\FileModel();
if (!empty($loadImages)) {
    $images = $fileModel->getImages();
    echo view("admin/file-manager/_file_manager_image", ['images' => $images]);
}
if (!empty($loadQuizImages)) {
    $quizImages = $fileModel->getQuizImages();
    echo view("admin/file-manager/_file_manager_quiz_image", ['quizImages' => $quizImages]);
}
if (!empty($loadFiles)) {
    $files = $fileModel->getFiles();
    echo view("admin/file-manager/_file_manager", ['files' => $files]);
}
if (!empty($loadVideos)) {
    $videos = $fileModel->getVideos();
    echo view("admin/file-manager/_file_manager_video", ['videos' => $videos]);
}
if (!empty($loadAudios)) {
    $audios = $fileModel->getAudios();
    echo view("admin/file-manager/_file_manager_audio", ['audios' => $audios]);
} ?>