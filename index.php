<?php
/**
 * عقل برو - الصفحة الرئيسية
 * AqlPro AI Builder - Main Page
 */
require_once __DIR__ . '/config/config.php';
// ملاحظة: لا نطلب database.php هنا لأنها تعيد $pdo وستوقف الصفحة
// نطلبها فقط في ملفات API
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عقل برو | منصة بناء وتدريب نماذج الذكاء الاصطناعي</title>
    <meta name="description" content="ابنِ نماذج ذكاء اصطناعي خاصة بك، درّبها على بياناتك، واختبرها مباشرة - كل ذلك في مكان واحد.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app">
    <!-- الترويسة -->
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <div class="logo-icon">🧠</div>
                <div class="logo-text">
                    <h1>عقل برو</h1>
                    <p>منصة بناء وتدريب نماذج الذكاء الاصطناعي</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-ghost btn-icon" onclick="currentModel = createDefaultModel(); renderBuilder(); switchTab('builder')" title="نموذج جديد">+</button>
                <button class="btn btn-ghost btn-icon" onclick="toggleTheme()" title="تبديل المظهر">🌙</button>
            </div>
        </div>
    </header>

    <!-- البانر الترحيبي -->
    <section class="hero">
        <div class="container hero-content">
            <div>
                <span class="hero-badge">✨ تعلّم آلي بدون كود</span>
                <h2>
                    ابنِ نموذج ذكاء اصطناعي خاص بك
                    <br>
                    <span class="gradient">ودرّبه بنفسك</span>
                </h2>
                <p>صمّم بنية الشبكة العصبية، اختر البيانات وهايبربارامترات التدريب، وراقب نموذجك يتعلّم خطوة بخطوة. ثم اختبره مباشرة في محادثة حيّة. كل ذلك في مكان واحد.</p>
                <div class="hero-features">
                    <span class="hero-feature">4 معماريات جاهزة</span>
                    <span class="hero-feature">6 مجموعات بيانات</span>
                    <span class="hero-feature">تتبّع لحظي للتدريب</span>
                    <span class="hero-feature">رفع بياناتك الخاصة</span>
                </div>
            </div>
            <div style="display: flex; justify-content: center;">
                <svg viewBox="0 0 300 300" style="width: 100%; max-width: 320px; height: auto;">
                    <?php
                    $layers = [4, 6, 6, 3];
                    foreach ($layers as $li => $count) {
                        if ($li < count($layers) - 1) {
                            $nextCount = $layers[$li + 1];
                            $xs = ($li + 1) * (300 / (count($layers) + 1));
                            $xn = ($li + 2) * (300 / (count($layers) + 1));
                            for ($i = 0; $i < $count; $i++) {
                                $ys = ($i + 1) * (300 / ($count + 1));
                                for ($j = 0; $j < $nextCount; $j++) {
                                    $yn = ($j + 1) * (300 / ($nextCount + 1));
                                    echo "<line x1='$xs' y1='$ys' x2='$xn' y2='$yn' stroke='currentColor' style='color: var(--primary); opacity: 0.2;' stroke-width='1'/>";
                                }
                            }
                        }
                    }
                    foreach ($layers as $li => $count) {
                        $x = ($li + 1) * (300 / (count($layers) + 1));
                        for ($i = 0; $i < $count; $i++) {
                            $y = ($i + 1) * (300 / ($count + 1));
                            echo "<circle cx='$x' cy='$y' r='8' fill='currentColor' style='color: var(--primary); opacity: 0.3;'/>";
                            echo "<circle cx='$x' cy='$y' r='5' fill='currentColor' style='color: var(--primary);'>
                                <animate attributeName='opacity' values='1;0.4;1' dur='2s' begin='" . ($li + $i) * 0.2 . "s' repeatCount='indefinite'/>
                            </circle>";
                        }
                    }
                    ?>
                </svg>
            </div>
        </div>
    </section>

    <!-- المحتوى الرئيسي -->
    <main class="container" style="flex: 1; padding-top: 1.5rem; padding-bottom: 2rem;">
        <!-- التبويبات -->
        <div class="tabs">
            <div class="tabs-list">
                <button class="tab-trigger active" data-tab="builder" onclick="switchTab('builder')">🧩 المُصمّم</button>
                <button class="tab-trigger" data-tab="training" onclick="switchTab('training')">⚡ التدريب</button>
                <button class="tab-trigger" data-tab="test" onclick="initChat(); switchTab('test')">💬 الاختبار</button>
                <button class="tab-trigger" data-tab="datasets" onclick="switchTab('datasets')">📊 البيانات</button>
                <button class="tab-trigger" data-tab="models" onclick="switchTab('models')">📚 مكتبتي</button>
            </div>
        </div>

        <!-- تبويب: المُصمّم -->
        <div class="tab-content active" id="tab-builder">
            <div class="grid grid-3">
                <!-- العمود الأيمن: الإعدادات -->
                <div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>⚙️ معلومات النموذج</h3>
                        </div>
                        <div class="card-body">
                            <div class="field">
                                <label for="model-name">اسم النموذج</label>
                                <input type="text" id="model-name" class="input" onchange="updateModelField('name', this.value)" placeholder="مثال: مصنّف الأرقام">
                            </div>
                            <div class="field">
                                <label for="model-description">الوصف (اختياري)</label>
                                <textarea id="model-description" class="textarea" rows="2" onchange="updateModelField('description', this.value)" placeholder="وصف موجز لما يفعله النموذج..."></textarea>
                            </div>
                            <div class="field-row">
                                <div class="field">
                                    <label for="model-input-shape">شكل المدخل</label>
                                    <input type="text" id="model-input-shape" class="input" onchange="updateModelField('inputShape', this.value)" placeholder="784">
                                </div>
                                <div class="field">
                                    <label for="model-output-classes">عدد المخرجات</label>
                                    <input type="number" id="model-output-classes" class="input" min="1" max="1000" onchange="updateModelField('outputClasses', parseInt(this.value))" value="10">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>💻 نوع المعمارية</h3>
                            <p>اختر المعمارية المناسبة لمهمتك</p>
                        </div>
                        <div class="card-body">
                            <div class="arch-grid" id="arch-list"></div>
                        </div>
                    </div>
                </div>

                <!-- العمود الأوسط: الطبقات -->
                <div>
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                <div>
                                    <h3>🧱 طبقات الشبكة العصبية</h3>
                                    <p>صمّم بنية شبكتك بطبقات قابلة للتخصيص</p>
                                </div>
                                <span class="badge badge-primary" id="layers-count">4 طبقة</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="layer-list" id="layers-list"></div>
                            <div class="layer-buttons">
                                <button class="layer-btn" onclick="addLayer('dense')">▦ كثيفة</button>
                                <button class="layer-btn" onclick="addLayer('conv2d')">▣ تلافيفية</button>
                                <button class="layer-btn" onclick="addLayer('lstm')">↻ LSTM</button>
                                <button class="layer-btn" onclick="addLayer('attention')">✦ انتباه</button>
                                <button class="layer-btn" onclick="addLayer('dropout')">○ إهمال</button>
                                <button class="layer-btn" onclick="addLayer('flatten')">▬ تسطيح</button>
                                <button class="layer-btn" onclick="addLayer('embedding')">◇ تضمين</button>
                                <button class="layer-btn" onclick="addLayer('pooling')">▽ تجميع</button>
                            </div>
                        </div>
                        <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="text-muted" style="font-size: 0.75rem;">📊 إجمالي الخلايا</span>
                            <button class="btn" onclick="saveModel(currentModel).then(id => { if (id) { currentModel.id = id; } })">💾 حفظ النموذج</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تبويب: التدريب -->
        <div class="tab-content" id="tab-training">
            <div class="grid grid-3">
                <div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>📊 مجموعة البيانات</h3>
                            <p>اختر البيانات التي سيتعلّم منها النموذج</p>
                        </div>
                        <div class="card-body">
                            <select class="select" onchange="currentModel.training.dataset = this.value; renderTrainingPanel();">
                                <?php
                                $datasets = [
                                    'mnist' => 'MNIST - الأرقام',
                                    'cifar10' => 'CIFAR-10 - صور ملوّنة',
                                    'fashion_mnist' => 'Fashion-MNIST - ملابس',
                                    'imdb' => 'IMDB - مراجعات',
                                    'custom_text' => 'نص مخصّص',
                                    'xor_logic' => 'بوابة XOR',
                                    'custom' => 'بيانات مخصّصة (مرفوعة)',
                                ];
                                foreach ($datasets as $key => $label) {
                                    echo "<option value='$key'>$label</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>⚙️ هايبربارامترات التدريب</h3>
                        </div>
                        <div class="card-body">
                            <div class="field">
                                <label>عدد الحقب: <strong id="epochs-value" class="mono">15</strong></label>
                                <input type="range" min="1" max="100" value="15" onchange="currentModel.training.epochs = parseInt(this.value); document.getElementById('epochs-value').textContent = this.value;">
                            </div>
                            <div class="field">
                                <label>معدّل التعلّم: <strong id="lr-value" class="mono">0.001</strong></label>
                                <input type="range" min="1" max="100" value="10" onchange="currentModel.training.learningRate = this.value / 10000; document.getElementById('lr-value').textContent = (this.value / 10000).toFixed(4);">
                            </div>
                            <div class="field">
                                <label>حجم الدفعة: <strong id="bs-value" class="mono">32</strong></label>
                                <input type="range" min="1" max="256" value="32" onchange="currentModel.training.batchSize = parseInt(this.value); document.getElementById('bs-value').textContent = this.value;">
                            </div>
                            <div class="field-row">
                                <div class="field">
                                    <label>المُحسِّن</label>
                                    <select class="select" onchange="currentModel.training.optimizer = this.value;">
                                        <option value="adam">Adam</option>
                                        <option value="adamw">AdamW</option>
                                        <option value="sgd">SGD</option>
                                        <option value="rmsprop">RMSprop</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>دالة الخسارة</label>
                                    <select class="select" onchange="currentModel.training.lossFunction = this.value;">
                                        <option value="crossentropy">CrossEntropy</option>
                                        <option value="mse">MSE</option>
                                        <option value="binary_crossentropy">Binary CE</option>
                                        <option value="mae">MAE</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                                <div>
                                    <h3>⚡ لوحة التدريب</h3>
                                    <p>النموذج: <strong id="training-model-name"></strong></p>
                                </div>
                                <button class="btn btn-lg" id="train-button" onclick="startTraining()">▶ ابدأ التدريب</button>
                            </div>
                        </div>
                        <div class="card-body" id="training-content"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تبويب: الاختبار -->
        <div class="tab-content" id="tab-test">
            <div class="chat-container">
                <div class="card" style="overflow: hidden;">
                    <div class="chat-header">
                        <div class="chat-bot-info">
                            <div class="chat-avatar">🤖</div>
                            <div>
                                <h3 style="font-size: 1rem; font-weight: 700;" id="chat-model-name">نموذجي الأول</h3>
                                <p style="font-size: 0.75rem; color: var(--muted);" id="chat-model-status">غير مدرّب</p>
                            </div>
                        </div>
                        <span class="badge badge-primary" id="chat-arch-badge">MLP</span>
                    </div>
                    <div class="chat-messages" id="chat-messages"></div>
                    <div class="chat-examples" id="chat-examples"></div>
                    <div class="chat-input-area">
                        <textarea id="chat-input" class="chat-input" placeholder="اكتب رسالتك أو مدخلك هنا..." rows="1"></textarea>
                        <button class="btn btn-icon" onclick="sendMessage()" style="height: 2.75rem;">▶</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- تبويب: البيانات -->
        <div class="tab-content" id="tab-datasets">
            <div style="margin-bottom: 1rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">📊 البيانات</h2>
                <p class="text-muted" style="font-size: 0.875rem; margin-top: 0.25rem;">ارفع بياناتك الخاصة (CSV / JSON) لتدريب النماذج عليها</p>
            </div>
            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3>📤 رفع بيانات جديدة</h3>
                        <p>الصق بياناتك أو ارفع ملف CSV / JSON من جهازك</p>
                    </div>
                    <div class="card-body">
                        <div class="tabs" style="margin-bottom: 1rem;">
                            <div class="tabs-list">
                                <button class="tab-trigger active" onclick="document.querySelectorAll('[data-ds-tab]').forEach(t => t.classList.add('hidden')); document.querySelector('[data-ds-tab=paste]').classList.remove('hidden'); this.classList.add('active'); this.nextElementSibling.classList.remove('active');">✍️ لصق يدوي</button>
                                <button class="tab-trigger" onclick="document.querySelectorAll('[data-ds-tab]').forEach(t => t.classList.add('hidden')); document.querySelector('[data-ds-tab=file]').classList.remove('hidden'); this.classList.add('active'); this.previousElementSibling.classList.remove('active');">📁 رفع ملف</button>
                            </div>
                        </div>
                        <div data-ds-tab="paste">
                            <div class="field">
                                <label for="ds-name">اسم مجموعة البيانات</label>
                                <input type="text" id="ds-name" class="input" placeholder="مثال: مراجعات المنتجات">
                            </div>
                            <div class="field">
                                <label for="ds-description">الوصف (اختياري)</label>
                                <input type="text" id="ds-description" class="input" placeholder="وصف موجز للبيانات">
                            </div>
                            <div class="field">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <label for="ds-content">المحتوى (CSV أو JSON)</label>
                                    <div style="display: flex; gap: 0.25rem;">
                                        <button class="btn btn-ghost btn-sm" onclick="applySample('csv')">مثال CSV</button>
                                        <button class="btn btn-ghost btn-sm" onclick="applySample('json')">مثال JSON</button>
                                    </div>
                                </div>
                                <textarea id="ds-content" class="textarea" style="min-height: 180px;" placeholder="الصق هنا بياناتك بصيغة CSV:

label,feature
&quot;إيجابي&quot;,&quot;منتج رائع&quot;
&quot;سلبي&quot;,&quot;سيء جداً&quot;

أو بصيغة JSON:

[{&quot;text&quot;:&quot;مرحبا&quot;,&quot;label&quot;:&quot;ترحيب&quot;}]" oninput="analyzeContent(this.value)"></textarea>
                            </div>
                        </div>
                        <div data-ds-tab="file" class="hidden">
                            <div class="field">
                                <label for="ds-name2">اسم مجموعة البيانات</label>
                                <input type="text" id="ds-name2" class="input" placeholder="مثال: مراجعات المنتجات" oninput="document.getElementById('ds-name').value = this.value">
                            </div>
                            <label class="upload-area" for="file-upload">
                                <div class="upload-icon">📁</div>
                                <div style="font-weight: 600; font-size: 0.875rem;">اختر ملف CSV / JSON / TXT</div>
                                <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">الحد الأقصى 2 ميجابايت</div>
                                <input type="file" id="file-upload" accept=".csv,.json,.txt,.tsv" style="display: none;" onchange="handleFileUpload(event)">
                            </label>
                        </div>
                        <div id="column-selectors" class="hidden" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <label style="font-size: 0.875rem; font-weight: 500;">اختر الأعمدة (اختياري)</label>
                            <div class="field-row" style="margin-top: 0.5rem;">
                                <div class="field">
                                    <label style="font-size: 0.7rem; color: var(--muted);">عمود المدخلات</label>
                                    <select class="select" id="input-column-select"></select>
                                </div>
                                <div class="field">
                                    <label style="font-size: 0.7rem; color: var(--muted);">عمود التسمية (Target)</label>
                                    <select class="select" id="label-column-select"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-block" id="upload-btn" onclick="uploadDataset()">📤 رفع البيانات</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>📚 البيانات المرفوعة</h3>
                        <p>اضغط على أي مجموعة لمعاينتها أو اختيارها للتدريب</p>
                    </div>
                    <div class="card-body">
                        <div id="datasets-list" style="display: flex; flex-direction: column; gap: 0.5rem; max-height: 420px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تبويب: مكتبتي -->
        <div class="tab-content" id="tab-models">
            <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">📚 مكتبة النماذج</h2>
                    <p class="text-muted" style="font-size: 0.875rem; margin-top: 0.25rem;">جميع نماذجك المحفوظة في مكان واحد</p>
                </div>
                <button class="btn" onclick="currentModel = createDefaultModel(); renderBuilder(); switchTab('builder')">+ نموذج جديد</button>
            </div>
            <div class="models-grid" id="models-grid"></div>
        </div>
    </main>

    <!-- التذييل -->
    <footer class="footer">
        <div class="container">
            عقل برو © 2026 - ابنِ نماذج ذكاء اصطناعي بسهولة، درّبها ببياناتك، واختبرها فوراً.
        </div>
    </footer>
</div>

<!-- التوستات -->
<div class="toast-container" id="toast-container"></div>

<!-- النافذة المنبثقة -->
<div id="modal" style="display: none;"></div>

<script src="assets/js/app.js"></script>
</body>
</html>
