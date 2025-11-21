<?php
// require_once __DIR__ . '../../helpers/url.php';
require_once __DIR__ . '/../controller/manajemenContentController.php';
global $params;
$module_id = $params['moduleId'] ?? null;
$course_id = $params['courseId'] ?? null;
$getAllModuleContentData = getAllModuleContentDatas($course_id, $module_id);
// $page_css = '<link rel="stylesheet" href="assets/css/learning-path.css" />';
renderFlashAlert();
$page_css  = '<link rel="stylesheet" href="' . basefolder() . '/assets/css/learning-path.css">';
ob_start();
?>

<!-- <div class="path">
      <div class="path-1">
        <span>HTML</span>
      </div>
      <div class="path-1">
        <span>CSS</span>
      </div>
      <div class="path-1">
        <span>JavaScript</span>
      </div>
      <div class="path-1">
        <span>PHP</span>
      </div>
    </div> -->
<style>
    /* GENERAL LAYOUT */
    .materi {
        max-width: 800px;
        margin: 40px auto;
        font-family: "Georgia", serif;
        line-height: 1.7;
        color: #222;
        padding: 0 20px;
    }

    .module-article {
        margin-bottom: 60px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    /* HEADERS */
    .article-header {
        font-family: "Georgia", serif;
        font-weight: 700;
        color: #111;
        margin: 20px 0 10px;
    }

    .article-header h1 {
        font-size: 2.5em;
    }

    .article-header h2 {
        font-size: 2em;
    }

    .article-header h3 {
        font-size: 1.75em;
    }

    /* PARAGRAPH */
    .article-paragraph {
        font-size: 1.1em;
        margin: 10px 0;
    }

    /* LISTS */
    .article-list {
        margin: 10px 0 20px 20px;
    }

    .article-list.ordered {
        list-style-type: decimal;
    }

    .article-list.unordered {
        list-style-type: disc;
    }

    /* BLOCKQUOTE */
    .article-quote {
        border-left: 4px solid #ccc;
        padding-left: 15px;
        margin: 20px 0;
        font-style: italic;
        color: #555;
    }

    .article-quote footer {
        display: block;
        text-align: right;
        font-style: normal;
        font-weight: bold;
        margin-top: 5px;
        color: #333;
    }

    /* LINK */
    .article-link a {
        color: #1a0dab;
        text-decoration: underline;
    }



    .code-wrapper {
        position: relative;
        margin-bottom: 20px;
        border-radius: 10px;
        overflow: hidden;
    }

    .copy-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 5px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        backdrop-filter: blur(8px);
        transition: .2s;
    }

    .copy-btn:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    pre {
        margin: 0 !important;
    }
</style>

<div class="container-border">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    <!-- <h1><?= var_dump($getAllModuleContentData['data']) ?></h1> -->
    <div class="materi">
        <?php foreach ($getAllModuleContentData['data'] as $key => $content): ?>
            <?php
            $blocks = json_decode($content->content_data, true);
            ?>

            <article class="module-article">
                <?php if (!empty($blocks)): ?>
                    <?php foreach ($blocks as $block): ?>
                        <?php
                        $type = $block['type'] ?? '';
                        $data = $block['data'] ?? [];
                        ?>

                        <?php if ($type === 'header'): ?>
                            <h<?= $data['level'] ?? 2 ?> class="article-header">
                                <?= htmlspecialchars($data['text'] ?? '') ?>
                            </h<?= $data['level'] ?? 2 ?>>

                        <?php elseif ($type === 'paragraph'): ?>
                            <p class="article-paragraph"><?= htmlspecialchars($data['text'] ?? '') ?></p>

                        <?php elseif ($type === 'list'): ?>
                            <ul class="article-list <?= $data['style'] ?? 'unordered' ?>">
                                <?php foreach ($data['items'] ?? [] as $item): ?>
                                    <li><?= htmlspecialchars($item['content'] ?? '') ?></li>
                                <?php endforeach; ?>
                            </ul>

                        <?php elseif ($type === 'quote'): ?>
                            <blockquote class="article-quote">
                                <?= htmlspecialchars($data['text'] ?? '') ?>
                                <?php if (!empty($data['caption'])): ?>
                                    <br>
                                    <br>
                                    <div class="flex justify-end" style="font-weight: 600;">— <?= htmlspecialchars($data['caption']) ?></div>
                                <?php endif; ?>
                            </blockquote>

                        <?php elseif ($type === 'linkTool'): ?>
                            <div class="article-link">
                                <a href="<?= htmlspecialchars($data['link'] ?? '#') ?>" target="_blank">
                                    <?= htmlspecialchars($data['link'] ?? '') ?>
                                </a>
                            </div>

                        <?php elseif ($type === 'code'): ?>
                            <div class="code-wrapper">
                                <button class="copy-btn">Copy</button>
                                <pre><code class="">
                                <?= htmlspecialchars($data['code'] ?? '') ?>
                                </code>
                                </pre>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php else: ?>
                    <p><em>Tidak ada data konten</em></p>
                <?php endif; ?>
            </article>

        <?php endforeach; ?>
        <div class="flex items-center justify-between">

            <form action="<?= basefolder() ?>/controller/homepagecontroller.php" method="post">
                <input type="hidden" name="module_id" value="<?=$module_id?>">
                <input type="hidden" name="course_id" value="<?= $course_id?>">
                <input type="hidden" name="action" value="prevModuleContent">
                <button type="submit" class="main-btn">Sebelumnya</button>
            </form>
            <form action="<?= basefolder() ?>/controller/homepagecontroller.php"  method="post">
                <input type="hidden" name="module_id" value="<?=$module_id?>">
                <input type="hidden" name="course_id" value="<?= $course_id?>">
                <input type="hidden" name="action" value="nextModuleContent">
                <button type="submit" class="main-btn">Selanjutnya</button>
            </form>
        </div>

        <!-- Highlight.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script>
            hljs.highlightAll();
        </script>
        <script>
            document.querySelectorAll('.copy-btn').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const code = btn.nextElementSibling.innerText;
                    navigator.clipboard.writeText(code);

                    btn.textContent = "Copied!";
                    setTimeout(() => btn.textContent = "Copy", 1500);
                });
            });
        </script>

    </div>

</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>