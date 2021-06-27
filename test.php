<?php
/**
 * @author Mr.lee <lwy@srun.com,liwenyu66@126.com>
 * @version v1.0.0 2021/6/27
 * @company 杭州瀚洋科技有限公司 www.srun.com
 */

use liwenyu\phpHelpers\StringDiff;

$template = '我爱你{a}，{b}';
$content = '我爱你中国，你最棒';

print_r(StringDiff::getDiff($template, $content));