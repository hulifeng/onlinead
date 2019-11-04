<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2019 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use app\portal\model\PortalPostModel;
use cmf\controller\HomeBaseController;
use think\Db;

class IndexController extends HomeBaseController
{
    public function index()
    {
        // 查询幻灯片
        $slideList = Db::name("slide")
            ->alias('fs')
            ->join("slide_item fsi", "fs.id = fsi.slide_id")
            ->where("fs.delete_time",  "0")
            ->where("fsi.status", "1")
            ->select();

        // 查询文章列表
        $articleList = PortalPostModel::with(['tags', 'categories'])->where("post_type", 1)->where("post_status", 1)->paginate(10);

        // 获取分类名称
        $categories = Db::name('portal_category')->where("delete_time", "0")->select();
        $categoryList = [];
        foreach ($categories as $value) {
            $categoryList[$value['id']] = $value['name'];
        }

        // 查询标签
        $tagList = Db::name('portal_tag')
            ->alias('pt')
            ->field("count(ptp.post_id) as num, pt.name")
            ->join("portal_tag_post ptp", "pt.id = ptp.tag_id")
            ->where("pt.status", 1)
            ->where("ptp.status", 1)
            ->group("ptp.tag_id")
            ->order("num", "desc")
            ->select();

        $this->assign('tag_list', $tagList);
        $this->assign('slide_list', $slideList);
        $this->assign('article_list', $articleList);
        $this->assign('category_list', $categoryList);
        $this->assign('page', $articleList->render());

        return $this->fetch(':index');
    }
}
