<?php
/**
 * Created by birdtool.com
 * Author: birdtool.com
 * webSite: www.birdtool.com
 * Date: 2019/11/7
 * Time: 下午4:25
 */

namespace plugins\birdtool_web404;
use cmf\lib\Plugin;

class BirdtoolWeb404Plugin extends Plugin
{

    public $info = [
        'name'        => 'BirdtoolWeb404',
        'title'       => '腾讯公益404页面',
        'description' => '腾讯公益404页面',
        'status'      => 1,
        'author'      => 'BirdTool.Com',
        'version'     => '1.0.0',
        'demo_url'    => 'https://www.birdtool.com',
        'author_url'  => 'https://www.birdtool.com'
    ];

    public $hasAdmin = 0;

    public function install()
    {
        // 动态修改异常页面路径
        cmf_set_dynamic_config([
            'app' => [
                'exception_tmpl' => CMF_ROOT . 'public/plugins/birdtool_web404/404.html' // 404页面可自定义修改
            ]
        ]);
        return true;
    }

    public function uninstall()
    {
        // 动态修改异常页面路径
        cmf_set_dynamic_config([
            'app' => [
                'exception_tmpl' => CMF_ROOT . 'vendor/thinkphp/tpl/think_exception.tpl'
            ]
        ]);
        return true;
    }
}