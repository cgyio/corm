<?php
/**
 * cgyio/resper 框架设置工具类
 */

namespace Cgy\module;

class Configer 
{
    /**
     * 预设的设置参数
     * !! 子类自定义
     */
    protected $init = [];

    //用户设置 origin 数据
    protected $opt = [];

    //经过处理后的 运行时参数
    protected $context = [];

    //已定义的常量
    public static $cnsts = [];

    /**
     * 构造
     * @param Array $opt 输入的设置参数
     * @return void
     */
    public function __construct($opt = [])
    {
        //应用用户设置
        $this->setConf($opt);
    }

    /**
     * 写入用户设置
     * !! 子类可覆盖
     * @param Array $opt 用户设置
     * @return $this
     */
    public function setConf($opt = [])
    {
        //保存用户设置原始值
        $this->opt = cgy_arr_extend($this->opt, $opt);

        //合并 用户设置 与 默认参数，保存到 context
        $ctx = $this->context;
        if (empty($ctx)) $ctx = cgy_arr_copy($this->init);
        $ctx = cgy_arr_extend($ctx, $opt);

        //处理设置值，支持格式：String, IndexedArray, Numeric, Bool, null,
        $this->context = $this->fixConfVal($ctx);

        //执行后续
        return $this->afterSetConf();
    }

    /**
     * 在 应用用户设置后 执行
     * !! 子类可覆盖
     * @return $this
     */
    public function afterSetConf()
    {
        //子类可自定义方法
        //...

        return $this;
    }

    /**
     * __get 访问 context
     * @param String $key
     * @return Mixed
     */
    public function __get($key)
    {
        /**
         * $this->field  -->  $this->context[field]
         */
        if (isset($this->context[$key])) {
            $ctx = $this->context[$key];
            //if (cgy_is_associate($ctx)) return (object)$ctx;
            return $ctx;
        }

        /**
         * $this->_field  -->  $this->init[field]
         */
        if (substr($key, 0, 1)==="_" && isset($this->init[substr($key, 1)])) {
            $k = substr($key, 1);
            return $this->init[$k];
        }
    }

    /**
     * 外部访问 context
     * @param String $key context 字段 或 字段 path： 
     *      foo | foo/bar  -->  context["foo"] | context["foo"]["bar"]
     * @return Mixed
     */
    public function ctx($key = "")
    {
        if ($key=="") return $this->context;
        if (!cgy_is_nemstr($key)) return null;
        $ctx = $this->context;
        if (isset($ctx[$key])) return $ctx[$key];
        return cgy_arr_find($ctx, $key);
    }

    /**
     * 处理设置值
     * 设置值支持格式：String, IndexedArray, Numeric, Bool, null
     * @param Mixed $val 要处理的设置值
     * @return Mixed 处理后的设置值，不支持的格式 返回 null
     */
    public function fixConfVal($val = null)
    {
        if (cgy_is_associate($val)) {
            $vn = [];
            foreach ($val as $k => $v) {
                $vn[$k] = $this->fixConfVal($v);
            }
            return $vn;
        }

        if (cgy_is_ntf($val)) {
            //"null true false"
            eval("\$val = ".$val.";");
        } else if (is_numeric($val)) {
            $val = $val*1;
        } else if (cgy_is_nemstr($val)) {
            if ("," == substr($val, 0,1) || false !== strpos($val, ",")) {
                //首字符为 , 或 包含字符 , 表示是一个 array
                $val = trim(trim($val), ",");
                $val = preg_replace("/\s+,/", ",", $val);
                $val = preg_replace("/,\s+/", ",", $val);
                $val = explode(",", $val);
                $val = array_map(function($i) {
                    return trim($i);
                }, $val);
            }
        } else if ($val=="" || is_bool($val) || cgy_is_indexed($val)) {
            //$val = $val;
        } else {
            $val = null;
        }

        return $val;
    }



    /**
     * static tools
     */

    /**
     * 定义常量
     * @param Array $defs
     * @param String $pre 常量前缀
     * @return Array
     */
    public static function def($defs = [], $pre="")
    {
        $pre = ($pre=="" || !cgy_is_nemstr($pre)) ? "" : strtoupper($pre)."_";
        foreach ($defs as $k => $v) {
            $k = $pre.strtoupper($k);
            $ln = count(explode("_",$k));
            if (cgy_is_associate($v) && !empty($v)) {
                self::def($v, $k);
            } else {
                if (!defined($k)) {
                    self::$cnsts[] = $k;
                    define($k, $v);
                }
            }
        }
        return $defs;
    }
    
}