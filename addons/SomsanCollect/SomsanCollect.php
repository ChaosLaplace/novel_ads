<?php
namespace addons\SomsanCollect;

use app\common\addons\Addon;
use think\Db;
use think\facade\Cache;
use think\facade\Env;

class SomsanCollect extends Addon{

    public $info = [
        'name'=>'SomsanCollect',
        'title'=>'采集单本小说',
        'description'=>'采集单本小说',
        'status'=>1,
        'author'=>'Somsan',
        'version'=>'1.0.0',
        'group'=>'',
        'mold'=>'web,wap,wechat',
        'sort'=>0,
        'exclusive'=>0
    ];

    public function install(){

        //插入菜单
        $info = Db::name('menu')->where(['title' => '采集单本', 'url' => 'admin/somsan_collect/index'])->find();
        if (empty($info)){
            $row = Db::name('menu')->insert([
                'title' => '采集单本',
                'pid' => '4',
                'sort' => '1',
                'url' => 'admin/somsan_collect/index',
                'hide' => '0',
                'tip' => '',
                'group' => '采集',
                'icon' => 'layui-icon layui-icon-senior',
            ]);
            if (empty($row)){
                return false;
            }
        }
        $path = Env::get('root_path').'application/admin';
        $addons_path = Env::get('root_path').'addons/SomsanCollect';

        $view_dir = $path.'/view/somsan_collect';
        if (!is_dir($view_dir)){
            mkdir($view_dir);
        }

        //复制文件
        $rc = copy($addons_path.'/code/SomsanCollect.php', $path.'/controller/SomsanCollect.php');
        $rv = copy($addons_path.'/code/somsan_collect/index.html', $view_dir.'/index.html');
        if ($rc && $rv) {
            Cache::rm('admin_menu');
            return true;
        } else {
            return false;
        }
    }

    public function uninstall(){
        //删除菜单
        Db::name('menu')->where(['title' => '采集单本', 'url' => 'admin/somsan_collect/index'])->delete();
        //删除文件
        $path = Env::get('root_path').'application/admin';

        $view_dir = $path.'/view/somsan_collect';
        $controller = $path.'/controller/SomsanCollect.php';
        $view = $view_dir.'/index.html';
        if (file_exists($controller)){
            unlink($controller);
        }
        if (file_exists($view)){
            unlink($view);
        }
        if (is_dir($view_dir)){
            rmdir($view_dir);
        }
        Cache::rm('admin_menu');
        return true;
    }
}
