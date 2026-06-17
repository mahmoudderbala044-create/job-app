<?php
// صفحة مؤقتة للتشخيص فقط - احذفها بعد الانتهاء
echo "<h2>PHP Upload Settings (from Apache)</h2>";
echo "upload_tmp_dir: " . ini_get('upload_tmp_dir') . "<br>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "file_uploads: " . ini_get('file_uploads') . "<br>";
echo "<hr>";
echo "<h2>php.ini path used by Apache:</h2>";
echo php_ini_loaded_file() . "<br>";
echo "<h2>Tmp dir writable?</h2>";
$tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
echo "Tmp dir: $tmpDir <br>";
echo "Writable: " . (is_writable($tmpDir) ? '<span style=color:green>YES ✓</span>' : '<span style=color:red>NO ✗</span>') . "<br>";
