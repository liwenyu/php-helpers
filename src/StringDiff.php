<?php

/**
 * Match the difference between two strings
 * What functions does it apply to?
 * such as: SMS template
 * At present, SMS sending is regulated by law, and template SMS was born. Template SMS generally requires that only
 * template variables and values are submitted to the SMS gateway without submitting the original text, which will
 * have a greater impact on the original business system.
 *
 * @author Mr.lee <liwenyu66@126.com;liwenyu66@gmail.com>
 * @version v1.0.0 2021/6/25
 */

namespace liwenyu\phpHelpers;

/**
 * Class StringDiff
 */
class StringDiff
{
    const STRING_TYPE = 1;
    const ARRAY_TYPE = 2;

    /**
     * Get the difference between two strings
     *
     * @param $template
     */
    public static function getDiff($template, $content)
    {
        $result = [];
        // Formatting template
        $template = self::formatContent($template, self::ARRAY_TYPE);
        if (!$template) {
            return false;
        }

        $tmpKey = '';
        foreach ($template as $key => $val) {
            // 查询指定字符在字符串中的首次出现的位置，就是找模板中的特定字符是否在 content 内容中
            $pos = strpos($content, $val);
            // 不存在
            if ($pos === false) {
                // 记录差异，这就是变量
                $tmpKey .= $val;
                // echo "在 <{$this->content}> 中没找到 $val, $tmpKey" . PHP_EOL;

                // 数组最后一个值不能和循环的 key 相同，不相同则说明还可以进行下一次循环，如果已经循环到了最终一次
                // 就要开始处理变量在最后的情况了
                if (max(array_keys($template)) != $key) {
                    continue;
                }

                // 循环已经到头了，该赋值了
                $result[$tmpKey] = $content;
                break;
            }

            // echo "在 <{$this->content}> 中找到 $val 位置是 $pos" . PHP_EOL;
            // 在 content 中找到了特定字符，则将模板内的值清一下
            unset($template[$key]);
            // 将找到的这一串字符截取出来，这是变量的值
            $value = substr($content, 0, $pos);
            if ($tmpKey != '' && $value != '') {
                // 将 变量和值 保存到结果集中
                $result[$tmpKey] = $value;
            }

            // 处理原字符串
            // 将刚才匹配到的内容删掉
            $content = substr($content, strlen($value) + strlen($val));
            // 将临时变量 key 初始化
            $tmpKey = '';
        }

        return $result;
    }

    /**
     * 将字符串进行预处理
     *
     * @param $strings
     * @param int $type
     * @return array|string
     */
    private static function formatContent($strings, $type = 1)
    {
        //array_filter 函数会去除值为 0 的,因此需要回调处理
        $res = array_filter(preg_split('//u', $strings), function ($v) {
            if ($v === '' || $v === null) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);

        if ($type == self::STRING_TYPE) {
            return implode($res, '');
        }
        return array_merge($res, []);
    }
}