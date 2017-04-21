<?php
/**
 * Class Article 文章
 */
class Article extends Admin_Controller
{
    /**
     * index
     * 首页列表
     * @param int $page 分页
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:07
     */
    public function index(int $page = 0)
    {
        // 分页页码
        $page = 0 >= $page ? 1 : $page;
        // view data
        $this->_headerViewVar['h1_title'] = '文章列表';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        $this->_viewVar['table_header'] = ['#', '文章标题', '所属类型', '短标题', '状态', '操作'];

        // model
        $this->load->model('article_model');
        // 获取记录总条数
        $Conditions = ['cid'=>1];
        $this->article_model->setConditions($Conditions);
        $count = $this->article_model->count(false);
        if(! empty($count)) {
            // Page configure
            $this->load->library('pagination');
            $config['base_url'] = base_url("article/index");
            $config['total_rows'] = (int)$count;
            $this->pagination->initialize($config);
            $this->_viewVar['page'] = $this->pagination->create_links();
            // get page data
            $this->_viewVar['data'] = $this->article_model
                ->setSelectFields('id,title,cid,subtitle,status')
                ->getPage($page, ADMIN_PAGE_SIZE);

        }

        // 加载视图
        $this->load_view();
    }

    /**
     * add 文章添加
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:25
     */
    public function add(){
        if('post' == $this->input->method()){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $insert_result = $this->article_model->add($_POST);
            if(!empty($insert_result)){
                //$status_code = 0, $msg = '', $data = []
                http_ajax_response(0,'添加文章成功',[]);
                return;
            }
            http_ajax_response(1,'添加文章失败',[]);
            return;
        }
        // view data
        $this->_headerViewVar['h1_title'] = '添加文章';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view();
    }

    /**
     * edit 文章修改
     *
     * @param int $id 文章id
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function edit(int $id=0){
        $_id = !empty($_REQUEST['id'])?$_REQUEST['id']:0;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['title']) ||
                empty($_POST['subtitle']) ||
                !isset($_POST['cid']) ||
                empty($_POST['source']) ||
                empty($_POST['author']) ||
                empty($_POST['resume']) ||
                !isset($_POST['pub_date']) ||
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = $_POST['title'];       //标题
            $article_info['subtitle']      = $_POST['subtitle'];    //短标题
            $article_info['created_id']    = $_POST['created_id'];  //创建者(FK:user id)
            $article_info['cid']           = $_POST['cid'];         //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['pic']           = $_POST['pic'];         //缩略图
            $article_info['source']        = $_POST['source'];      //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = $_POST['author'];      //作者
            $article_info['resume']        = $_POST['resume'];      //摘要
            $article_info['pub_date']      = $_POST['pub_date'];    //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改文章成功',[]);
                return;
            }
            http_ajax_response(1,'修改文章失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '修改文章';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view();
    }

    /**
     * business 业务介绍=>id:1
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function business(){

        $_id = 1;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = '业务介绍';      //标题
            $article_info['subtitle']      = '业务介绍';      //短标题
            $article_info['created_id']    = '1';           //创建者(FK:user id)
            $article_info['cid']           = '2';           //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['source']        = '1';           //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = 'admin';       //作者
            $article_info['resume']        = empty($_POST['resume']) ? '业务介绍' : (string)$_POST['resume'];      //摘要
            $article_info['pub_date']      = time();        //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改成功',[]);
                return;
            }
            http_ajax_response(1,'修改失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '业务介绍';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view();
    }

    /**
     * cases 合作案例=>id:2
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function cases(){

        $_id = 2;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = '合作案例';      //标题
            $article_info['subtitle']      = '合作案例';      //短标题
            $article_info['created_id']    = '1';           //创建者(FK:user id)
            $article_info['cid']           = '2';           //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['source']        = '1';           //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = 'admin';       //作者
            $article_info['resume']        = empty($_POST['resume']) ? '合作案例' : (string)$_POST['resume'];      //摘要
            $article_info['pub_date']      = time();        //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改成功',[]);
                return;
            }
            http_ajax_response(1,'修改失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '合作案例';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view('article/business');
    }

    /**
     * property 知识产权服务=>id:3
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function property(){

        $_id = 3;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = '知识产权服务';      //标题
            $article_info['subtitle']      = '知识产权服务';      //短标题
            $article_info['created_id']    = '1';           //创建者(FK:user id)
            $article_info['cid']           = '2';           //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['source']        = '1';           //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = 'admin';       //作者
            $article_info['resume']        = empty($_POST['resume']) ? '知识产权服务' : (string)$_POST['resume'];      //摘要
            $article_info['pub_date']      = time();        //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改成功',[]);
                return;
            }
            http_ajax_response(1,'修改失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '知识产权服务';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view('article/business');
    }

    /**
     * price 价格管控id=>4
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function price(){

        $_id = 4;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = '价格管控';      //标题
            $article_info['subtitle']      = '价格管控';      //短标题
            $article_info['created_id']    = '1';           //创建者(FK:user id)
            $article_info['cid']           = '2';           //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['source']        = '1';           //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = 'admin';       //作者
            $article_info['resume']        = empty($_POST['resume']) ? '价格管控' : (string)$_POST['resume'];    //摘要
            $article_info['pub_date']      = time();        //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改成功',[]);
                return;
            }
            http_ajax_response(1,'修改失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '价格管控';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view('article/business');
    }

    /**
     * about 联系我们=>id:5
     *
     * @author yangbiao<yangbiao@anhao.cn>
     * @date 2016-11-20 14:12:47
     */
    public function about(){

        $_id = 5;
        if(!empty($_id)){
            $id = $_id;
        }
        if('post' == $this->input->method() && !empty($id)){
            $this->load->helper('http');
            // model
            $this->load->model('article_model');
            // 获取记录总条数
            $_POST['created_id']    = 1;
            $_POST['cid']           = 2;
            $_POST['pic']           = 123;
            if(
                empty($_POST['content']) ||
                !isset($_POST['status'])
            )
            {
                http_ajax_response(1,'字段有空存在，修改文章失败',[]);
                return;
            }
            $article_info['title']         = '联系我们';      //标题
            $article_info['subtitle']      = '联系我们';      //短标题
            $article_info['created_id']    = '1';           //创建者(FK:user id)
            $article_info['cid']           = '2';           //所属类型id[1:日本,2:韩国3:欧美]
            $article_info['source']        = '1';           //来源[1:后台录入,2:网上抄袭]
            $article_info['author']        = 'admin';       //作者
            $article_info['resume']        = empty($_POST['resume']) ? '联系我们' : (string)$_POST['resume'];   //摘要
            $article_info['pub_date']      = time();        //发表日期
            $article_info['content']       = $_POST['content'];     //文章内容
            $article_info['status']        = $_POST['status'];      //状态[0:正常]
            $this->article_model->setUpdateData($article_info);
            $edit_result = $this->article_model->edit($id);
            if(!empty($edit_result)){
                http_ajax_response(0,'修改成功',[]);
                return;
            }
            http_ajax_response(1,'修改失败',[]);
            return;
        }
        $this->load->model('article_model');
        $this->article_model->setSelectFields('*');
        $this->_viewVar['data'] = $this->article_model->find($id);
        // view data
        $this->_headerViewVar['h1_title'] = '联系我们';
        $this->_headerViewVar['method_name'] = __FUNCTION__;
        // 加载视图
        $this->load_view('article/business');
    }


}