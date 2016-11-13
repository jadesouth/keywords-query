<?php

/**
 * Class MY_Model 应用的基模型
 *
 * @property CI_DB_query_builder    $db
 * @property CI_Loader              $load
 *
 * @author wangnan <wangnanphp@163.com>
 * @date   2016-11-11 00:41:28
 */
class MY_Model extends CI_Model
{
    /**
     * @var string 操作的主表名
     */
    protected $_table;
    /**
     * @var string 查询数据库的字段
     */
    protected $_selectFields = 'id';
    /**
     * @var array 查询条件
     */
    protected $_conditions = [];
    /**
     * @var array 插入的数据
     */
    protected $_insertData = [];
    /**
     * @var array 更新的数据
     */
    protected $_updateData = [];

    /**
     * MY_Model constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // 加载DB类
        $this->load->database();
        // 主表名和调用的模型名相同
        $this->_table = strtolower(substr(get_class($this), 0, -6));
    }

    /**
     * get_page 分页获取模型指定表的数据
     *
     * @param int $page      第几页
     * @param int $page_size 页大小,默认为20
     * @param string $order  排序
     * @param array $where   额外的查询条件
     *
     * @return array 结果集
     * @author wangnan
     * @date   2016-05-04 11:50:56
     */
    public function getPage(int $page = 0, int $page_size = 20, string $order = '', array $where = [])
    {
        // search
        if (! empty($where)) {
            $this->_conditions = $where;
        }
        // page limit offset
        $page = 0 >= $page ? 1 : $page;
        $limit = 0 >= $page_size ? 20 : $page_size;
        $offset = 0 > $page ? 0 : ($page - 1) * $page_size;
        $this->_conditions['LIMIT'] = [$limit, $offset];
        // order
        $this->_conditions['ORDER'] = empty($order) ? 'created_at DESC' : $order;
        $this->conditions();
        // select
        $select_filed = empty($this->_selectFields) ? 'id' : $this->_selectFields;
        $this->_selectFields = 'id';
        return $this->db->select($select_filed)
            ->from($this->_table)
            ->get()
            ->result_array();
    }

    /**
     * find 根据数据表的ID查询一条数据
     *
     * @param int $id 数据ID
     * @return array|bool 查询的结果集
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 00:22:55
     */
    public function find(int $id)
    {
        if(0 >= $id) {
            return false;
        }

        return $this->db->select($this->_selectFields)
            ->from($this->_table)
            ->where(['id' => $id, 'deleted_at' => '0000-00-00 00:00:00'])
            ->get()
            ->row_array();
    }

    /**
     * get 根据条件获取一条数据
     *
     * @return array
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 19:36:09
     */
    public function get()
    {
        $this->conditions();
        return $this->db->select($this->_selectFields)
            ->from($this->_table)
            ->get()
            ->row_array();
    }

    /**
     * create 单条添加数据方法
     *
     * @param array $data 需要插入的数据
     * @return mixed 成功:插入的主键, 失败:false
     *
     * @author wangnan
     * @date   2016-11-13 13:57:50
     */
    public function create(array $data = [])
    {
        $data = array_merge($this->_insertData, $data);
        if (empty($data) || ! is_array($data)) {
            return false;
        }

        $this->_insertData = [];

        return true === $this->db->insert($this->_table, $data) ? $this->db->insert_id() : false;
    }

    /**
     * createBatch 批量插入数据
     *
     * @param array $data 需要插入的数据,二维数组,每一维代表一条数据
     * @return mixed 插入的行数或false
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 13:58:52
     */
    public function createBatch(array $data)
    {
        $data = array_merge($this->_insertData, $data);
        if (empty($data) || ! is_array($data)) {
            return false;
        }

        $this->_insertData = [];

        return $this->db->insert_batch($this->_table, $data);
    }

    /**
     * count 查询记录总条数
     *
     * @return int 查询记录的总条数
     * @author wangnan
     * @date   2016-11-13 21:46:21
     */
    public function count()
    {
        $this->conditions();
        return $this->db->from($this->_table)
            ->count_all_results();
    }

    /**
     * update 更新数据
     *
     * @param array $data 跟新的数据
     *
     * @return bool
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 22:41:15
     */
    public function update(array $data = [])
    {
        $data = array_merge($this->_updateData, $data);
        echo 6;
        if (empty($data) || ! is_array($data)) {
            return false;
        }
        $this->_updateData = [];
        echo 7;
        $this->conditions();
        echo 8;
        return $this->db->update($this->_table, $data);
    }

    protected function conditions(array $conditions = [], string $operator = 'AND')
    {
        static $i = 1;
        echo $i++;
        $conditions = empty($conditions) ? $this->_conditions : $conditions;
        if(empty($conditions)) {
            return false;
        }
var_dump($conditions);
        // 对 conditions 按照规则进行解析
        foreach ($this->_conditions as $condition_k => $condition_v) {
            switch (strtoupper($condition_k)) {
                case 'AND':
                case 'OR':
                    $this->db->group_start();
                    var_dump($condition_v, $condition_k);
                    $this->conditions($condition_v, $condition_k);
                    $this->db->group_end();
                    break;
                case 'GROUP':
                    $this->db->group_by($condition_v);
                    break;
                case 'ORDER':
                    $this->db->order_by($condition_v);
                    break;
                case 'LIMIT' :
                    $this->db->limit($condition_v[0], $condition_v[1]);
                    break;
                default:
                    $this->conditionOperator($operator, $condition_k, $condition_v);
                    break;
            }
        }

        $this->db->where('deleted_at', '0000-00-00 00:00:00');
        // 清理查询条件
        $this->_conditions = [];

        return $this;
    }

    private function conditionOperator(string $logical, string $expression, $value)
    {
        $logical = strtoupper($logical);
        if('AND' != $logical || 'OR' != $logical || empty($expression)) {
            return false;
        }

        // 区分出字段名和操作符
        $expression_array = explode(' ', $expression);
        $field = $expression_array[0]; // 字段名
        $operator = empty($expression_array[1]) ? '' : $expression_array[1]; // 操作符
        if(empty($field) || empty($operator)) {
            return false;
        }

        // 根据具体的操作符选择执行的条件
        switch ($operator) {
            case '=':
            case '!=':
            case '>':
            case '>=':
            case '<':
            case '<=':
                if('AND' == $logical) {
                    $this->db->where($expression, $value);
                } else if ('OR' == $logical) {
                    $this->db->or_where($expression, $value);
                }
                break;
            case '<>': // IN
                if('AND' == $logical) {
                    $this->db->where_in($field, $value);
                } else if ('OR' == $logical) {
                    $this->db->or_where_in($field, $value);
                }
                break;
            case '!<>': // NOT IN
                if('AND' == $logical) {
                    $this->db->where_not_in($field, $value);
                } else if ('OR' == $logical) {
                    $this->db->or_where_not_in($field, $value);
                }
                break;
            case '><':  // BETWEEN AND
                if('AND' == $logical) {
                    $this->db->where("{$field} BETWEEN  {$value[0]} AND {$value[1]}");
                } else if ('OR' == $logical) {
                    $this->db->or_where("{$field} BETWEEN  {$value[0]} AND {$value[1]}");
                }
                break;
            case '!><':  // NOT BETWEEN AND
                if('AND' == $logical) {
                    $this->db->where("{$field} NOT BETWEEN  {$value[0]} AND {$value[1]}");
                } else if ('OR' == $logical) {
                    $this->db->or_where("{$field} NOT BETWEEN  {$value[0]} AND {$value[1]}");
                }
                break;
            case '%~':  // LIKE '%words'
                if('AND' == $logical) {
                    $this->db->like($field, $value, 'before');
                } else if ('OR' == $logical) {
                    $this->db->or_like($field, $value, 'before');
                }
                break;
            case '~%':  // LIKE 'words%'
                if('AND' == $logical) {
                    $this->db->like($field, $value, 'after');
                } else if ('OR' == $logical) {
                    $this->db->or_like($field, $value, 'after');
                }
                break;
            case '%%':  // LIKE '%words%'
                if('AND' == $logical) {
                    $this->db->like($field, $value, 'both');
                } else if ('OR' == $logical) {
                    $this->db->or_like($field, $value, 'both');
                }
                break;
            case '!%~':  // NOT LIKE '%words'
                if('AND' == $logical) {
                    $this->db->not_like($field, $value, 'before');
                } else if ('OR' == $logical) {
                    $this->db->or_not_like($field, $value, 'before');
                }
                break;
            case '!~%':  // NOT LIKE 'words%'
                if('AND' == $logical) {
                    $this->db->not_like($field, $value, 'after');
                } else if ('OR' == $logical) {
                    $this->db->or_not_like($field, $value, 'after');
                }
                break;
            case '!%%':  // NOT LIKE '%words%'
                if('AND' == $logical) {
                    $this->db->not_like($field, $value, 'both');
                } else if ('OR' == $logical) {
                    $this->db->or_not_like($field, $value, 'both');
                }
                break;
        }
    }

    /**
     * setUpdateData
     *
     * @param array $updateData
     * @return $this
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 22:08:48
     */
    public function setUpdateData(array $updateData)
    {
        $this->_updateData = $updateData;
        return $this;
    }

    /**
     * setInsertData
     *
     * @param array $insertData
     * @return $this
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 22:09:20
     */
    public function setInsertData(array $insertData)
    {
        $this->_insertData = $insertData;
        return $this;
    }

    /**
     * setConditions
     *
     * @param array $conditions
     * @return $this
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 22:09:30
     */
    public function setConditions(array $conditions)
    {
        $this->_conditions = $conditions;
        return $this;
    }

    /**
     * setSelectFields
     *
     * @param string $selectFields
     * @return $this
     *
     * @author wangnan <wangnanphp@163.com>
     * @date 2016-11-13 22:09:42
     */
    public function setSelectFields(string $selectFields)
    {
        $this->_selectFields = $selectFields;
        return $this;
    }
}
