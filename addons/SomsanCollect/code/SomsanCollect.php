<?php
namespace app\admin\controller;

use net\Gather;
use think\Db;

class SomsanCollect extends Base
{
    public function index(){

        $this->assign('meta_title', '单本采集');
        return $this->fetch();
    }

    public function get(){
        $url = request()->post('url');
        if (empty($url)){
            $this->error('目标地址URL不能为空');
        }
        $parse = parse_url($url);
        if (!isset($parse['host'])){
            $this->error('目标地址URL格式错误');
        }
        $host = $parse['host'];
        $collect = Db::name('collect')->where('source_url', 'like', '%'.$host.'%')->find();
        if (empty($collect)){
            $this->error('未找到 '.$host.' 相关的采集规则', '');
        }
        $info = model('admin/collect')->info($collect['id']);

        $return = Gather::field_content($info, $url);
        if(isset($return['error'])){
            $this->error($return['msg']);
        }
        if(empty($return['code'])){
            model('admin/collect')->sever_data($info, $return);
        }
        if(empty($return['msg'])){
            $return['msg'] = '添加成功';
            $return['status'] = 'ok';
        }
        $this->success($return['msg']);
    }
}