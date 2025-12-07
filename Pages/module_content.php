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
<style>
    /* GENERAL LAYOUT */
    .materi {
        /* max-width: 800px; */
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

    .left-col-module {
        padding: 40px 0px;
        position: sticky;
        top: 0;
    }

    /* Indicator gentle bounce */
    #indicator {
        width: 3px;
        background: #b084ff;
        position: absolute;
        left: -3px;
        height: 0px;
        top: 0;
        border-radius: 10px;
        transition:
            height 0.45s cubic-bezier(.34, 1.56, .64, 1),
            top 0.35s cubic-bezier(.34, 1.56, .64, 1);
    }

    #toc {
        position: relative;
        padding-left: 20px;
        border-left: 3px solid #e5d7ff;
    }

    .toc-item {
        margin: 10px 0;
        font-size: 15px;
        cursor: pointer;
        transition: 0.2s;
        padding: 4px 0;
    }

    .toc-item:hover {
        color: #8d5aff;
    }

    /* Active */
    .toc-item.active {
        font-weight: bold;
    }

    .congrats-box {
        background: #f3e8ff;
        padding: 15px;
        border-radius: 10px;
        margin-top: 30px;
        display: none;
        border-left: 5px solid #bb7bff;
    }
</style>

<div class="container-border">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    <?php
    if (empty((array)$getAllModuleContentData['data'])) : ?>
        <div class="nav-theme">
            <button id="toggleButton" class="btn-theme">
                <i id="icon" class="ri-sun-fill" style="font-size: 24px"></i>
            </button>
        </div>

        <div>data tida ada</div>
    <?php else: ?>
        <div class="materi">
            <?php $contents = $getAllModuleContentData['data']; ?>
            <?php
            ?>
            <div class="grid grid-cols-12">
                <div class="col-span-3 ">
                    <div class="left-col-module">

                        <div id="toc">
                            <div id="indicator" class="indicator"></div>
                        </div>

                        <div id="congrats" class="congrats-box">
                            <b>🎉 Congratulations!</b><br>
                            You've thoroughly explored this topic!
                        </div>
                    </div>
                </div>
                <div class="col-span-9">
                    <article class="module-article" id="module-area">
                        <?php if (!empty($contents)): ?>
                            <!-- ini daata modul konten -->
                            <?php foreach ($contents as $block_perContent): ?>

                                <?php
                                var_dump($block_perContent->module_content_id);
                                $blocks = json_decode($block_perContent->content_data, true);
                                ?>
                                <?php if (!empty($blocks)): ?>
                                    <?php
                                    $firstDtaBlock = $blocks[0];

                                    $title = getFirstText($firstDtaBlock);
                                    $anchorId = 'blok-' . $block_perContent->module_content_id;
                                    ?>

                                    <div class="content-marker"
                                        id="<?= $anchorId ?>"
                                        data-title="<?= htmlspecialchars($title) ?>">
                                    </div>
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
                                            <p class="article-paragraph" style="word-wrap: break-word;"><?= htmlspecialchars($data['text'] ?? '') ?></p>

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
                                                    <br><br>
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
                                                <pre><code><?= htmlspecialchars($data['code'] ?? '') ?></code></pre>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p><em>Tidak ada data konten</em></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p><em>Tidak ada data konten</em></p>
                        <?php endif; ?>
                    </article>
                    <div class="flex items-center justify-between">

                        <form action="<?= basefolder() ?>/controller/homepagecontroller.php" method="post">
                            <input type="hidden" name="module_id" value="<?= $module_id ?>">
                            <input type="hidden" name="course_id" value="<?= $course_id ?>">
                            <input type="hidden" name="action" value="prevModuleContent">
                            <button type="submit" class="main-btn">Sebelumnya</button>
                        </form>
                        <form action="<?= basefolder() ?>/controller/homepagecontroller.php" method="post">
                            <input type="hidden" name="module_id" value="<?= $module_id ?>">
                            <input type="hidden" name="course_id" value="<?= $course_id ?>">
                            <input type="hidden" name="action" value="nextModuleContent">
                            <button type="submit" class="main-btn">Selanjutnya</button>
                        </form>
                    </div>
                    <?= var_dump($firstDtaBlock) ?>
                </div>
            </div>


            <!-- Highlight.js -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
            <script>
                hljs.highlightAll();
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", (aa) => {

                    console.log('doccontentlod', aa);

                    const toc = document.getElementById("toc");
                    // const indicator = document.getElementById("indicator");
                    // const headings = document.querySelectorAll("#module-area h1, #module-area h2, #module-area h3");

                    let tocItems = [];
                    const markers = document.querySelectorAll("#module-area .content-marker");

                    markers.forEach((marker, index) => {
                        const item = document.createElement("div");
                        item.className = "toc-item";

                        const title = marker.dataset.title || `Bagian ${index + 1}`;
                          item.textContent = title.substring(0, 50);

                        item.addEventListener("click", () => {
                            marker.scrollIntoView({
                                behavior: "smooth"
                            });
                        });

                        toc.appendChild(item);
                        tocItems.push(item);
                    });

                    // // Generate TOC items
                    // markers.forEach((h, i) => {
                    //     const item = document.createElement("div");
                    //     item.className = "toc-item";
                    //     item.textContent = h.innerText;
                    //     item.dataset.target = i;

                    //     item.addEventListener("click", () => {
                    //         markers[i].scrollIntoView({
                    //             behavior: "smooth"
                    //         });
                    //     });

                    //     toc.appendChild(item);
                    //     tocItems.push(item);
                    // });

                    function updateIndicator() {
                        let index = -1;

                        markers.forEach((h, i) => {
                            // console.log('ini loop',h,i);
                            // console.log('ini loop',h.getBoundingClientRect(),i);

                            const rect = h.getBoundingClientRect();
                            if (rect.top <= 150) index = i;
                        });

                        // DOMRect {
                        //     x: 556.3125,
                        //     y: 267.51251220703125,
                        //     width: 1112.6375732421875,
                        //     height: 40.79999923706055,
                        //     top: 267.51251220703125,
                        //     …
                        // }
                        // bottom
                        //     :
                        //     308.3125114440918
                        // height
                        //     :
                        //     40.79999923706055
                        // left
                        //     :
                        //     556.3125
                        // right
                        //     :
                        //     1668.9500732421875
                        // top
                        //     :
                        //     267.51251220703125
                        // width
                        //     :
                        //     1112.6375732421875
                        // x
                        //     :
                        //     556.3125
                        // y
                        //     :
                        //     267.51251220703125[[Prototype]]:
                        //     DOMRect
                        if (index >= 0) {
                            tocItems.forEach((t) => t.classList.remove("active"));
                            tocItems[index].classList.add("active");

                            const active = tocItems[index];
                            const offsetTop = active.offsetTop;
                            const height = active.offsetHeight;

                            indicator.style.top = offsetTop + "px";
                            indicator.style.height = height + "px";
                        }
                        const last = markers[markers.length - 1].getBoundingClientRect();
                        if (last.top <= 300) {
                            document.getElementById("congrats").style.display = "block";

                        }
                    }

                    updateIndicator();
                    document.addEventListener("scroll", updateIndicator);

                    let hasFired = false;
                    window.addEventListener("scroll", () => {
                        if (hasFired) return;
                        const scrollTop = window.scrollY;

                        const docHeight = document.body.scrollHeight - window.innerHeight;
                        const progress = (scrollTop / docHeight) * 100;

                        // progressBar.style.height = progress + "%";

                        // 🎉 TRIGGER CONFETTI di sini!
                        // const lastBlock = contentBlocks[contentBlocks.length - 1];
                        // global 
                        const lastblocktoconfetti = markers[markers.length - 1];
                        console.log(lastblocktoconfetti);

                        const rect = lastblocktoconfetti.getBoundingClientRect();
                        if (rect.bottom <= window.innerHeight + 100) {

                            if (!hasFired) {
                                hasFired = true;
                                fireConfetti();
                            }
                        }
                        // if (progress >= 99 && !hasFired) {
                        //     fireConfetti();
                        //     hasFired = true;
                        // }
                    });

                });
                document.querySelectorAll('.copy-btn').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const code = btn.nextElementSibling.innerText;
                        navigator.clipboard.writeText(code);

                        btn.textContent = "Copied!";
                        setTimeout(() => btn.textContent = "Copy", 1500);
                    });
                });


                function fireConfetti() {
                    confetti({
                        particleCount: 130,
                        spread: 30,
                        origin: {
                            y: 0.9
                        }
                    });
                    setTimeout(() => confetti({
                        particleCount: 120,
                        spread: 100,
                        origin: {
                            y: 0.7
                        }
                    }), 600);
                    setTimeout(() => confetti({
                        particleCount: 190,
                        spread: 110,
                        origin: {
                            y: 0.8
                        }
                    }), 1200);
                }
            </script>

        </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../components/footer.php'; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layouts/mainUser.php';
?>