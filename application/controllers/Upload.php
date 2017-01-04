<?php

/**
 * Class Upload 处理各种上传任务
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-12-28 14:20:59
 */
class Upload extends MY_Controller
{
    private $_config = [];

    /**
     * Upload constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');

        // 设置基础的上传配置
        $this->_config = [
            'upload_path'      => FCPATH . 'resources/uploads/' . date('Ymd', time()),
//            'allowed_types'    => 'zip|7zip|rar|doc|docx|word|xls|xlsx|xl|ppt|pptx|pdf|txt|wma|rm|wav|wmv|avi|mp4|flv|swf|psd|gif|jpg|jpeg|png|bmp',
            'file_name'        => intval(microtime(true) * 10000),
            'file_ext_tolower' => true, // 文件后缀名将转换为小写
            'max_size'         => 4080,
        ];
    }

    /**
     * bannerImage 上传Banner图片
     *
     * @author wangnan <wangnanphp@163.com>
     * @date   2016-12-03 00:43:06
     */
    public function bannerImage()
    {
        $folder_data = date('Ymd', time());
        $this->_config['upload_path'] = FCPATH . 'resources/uploads/banners/' . $folder_data;
//        $this->_config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
        $this->_config['max_size'] = 4080;
        // init upload
        $this->upload->initialize($this->_config);
        // upload
        if (true === $this->upload->do_upload('banner-image')) { // success
            // 获取上传图片的信息
            $upload_file = $this->upload->data();
            $file_path = 'banners/' . $folder_data . '/' . $upload_file['orig_name'];
            http_ajax_response(0, 'Banner 图片上传成功', ['banner' => $file_path]);
        } else { // failed
            $this->send_failure_msg();
        }
    }

    /**
     * send_failure_msg http json 发送上传失败信息
     *
     * @author wangnan
     * @date   2016-12-26 00:42:37
     */
    private function send_failure_msg()
    {
        $failure_msg = $this->upload->display_errors('', '');
        $failure_msg = empty($failure_msg) ? '上传失败!' : $failure_msg;
        http_ajax_response(1, $failure_msg);
    }
}
