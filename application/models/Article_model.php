<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: yangbiao
 * Date: 16-5-4
 * Time: 下午21:31
 */

/**
 * Class Ad_model 商品分类模型
 */
class Article_model extends MY_Model
{
    public function add(array $article_info)
    {
        //默认数据
        $article_info['created_id'] = 1;
        $article_info['cid'] = 1;//当这个选自昂为1的时候，当前的操作是作为选项卡出现的
        $article_info['pic'] = 123;
        if(
            empty($article_info['title']) ||
            empty($article_info['subtitle']) ||
            !isset($article_info['cid']) ||
            empty($article_info['source']) ||
            empty($article_info['author']) ||
            empty($article_info['resume']) ||
            empty($article_info['pub_date']) ||
            empty($article_info['content']) ||
            !isset($article_info['status'])
        )
        {
            return false;
        }
        $this->load->helper(['tools', 'security']);
        $this->_insertData['title']         = $article_info['title'];       //标题
        $this->_insertData['subtitle']      = $article_info['subtitle'];    //短标题
        $this->_insertData['created_id']    = $article_info['created_id'];  //创建者(FK:user id)
        $this->_insertData['cid']           = $article_info['cid'];         //所属类型id[1:日本,2:韩国3:欧美]
        $this->_insertData['pic']           = $article_info['pic'];         //缩略图
        $this->_insertData['source']        = $article_info['source'];      //来源[1:后台录入,2:网上抄袭]
        $this->_insertData['author']        = $article_info['author'];      //作者
        $this->_insertData['resume']        = $article_info['resume'];      //摘要
        $this->_insertData['pub_date']      = $article_info['pub_date'];    //发表日期
        $this->_insertData['content']       = $article_info['content'];     //文章内容
        $this->_insertData['status']        = $article_info['status'];      //状态[0:正常]

        return $this->create();
    }

    public function edit(int $id)
    {
        if(0 >= $id ) {
            return false;
        }
        if(
            empty($this->_updateData['title']) ||
            empty($this->_updateData['subtitle']) ||
            !isset($this->_updateData['cid']) ||
            empty($this->_updateData['source']) ||
            empty($this->_updateData['author']) ||
            empty($this->_updateData['resume']) ||
            !isset($this->_updateData['pub_date']) ||
            empty($this->_updateData['content']) ||
            !isset($this->_updateData['status'])
        )
        {
            return false;
        }
        $this->load->helper(['tools', 'security']);

        $this->_conditions['AND']['id ='] = $id;
        return $this->update();
    }
}