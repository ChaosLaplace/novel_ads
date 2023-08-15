<?php
namespace app\admin\controller;

use net\Gather;
use think\Db;

class SomsanCollect extends Base
{
    public function index() {
        $this->assign('meta_title', '单本采集');
        return $this->fetch();
    }

    public function getNovel1() {
        $url = request()->post('url');
        if (empty($url)){
            $this->error('目标地址URL不能为空');
        }

        $return = Gather::field_content([], $url);
        // if( isset($return['error']) ) {
        //     $this->error($return['msg']);
        // }
        // if( empty($return['code']) ) {
        //     model('admin/collect')->sever_data($info, $return);
        // }
        // $return['msg'] = '添加成功';
        $this->success($return);
    }

    public function getNovel2() {
        $this->error('2'); 
    }
}