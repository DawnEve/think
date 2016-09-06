<?php
namespace Home\Model;
use Think\Model;

//模型就是为了返回数据，可以从数据库中来，也可以直接返回
class BlogModel extends Model{
    public function output(){
        return 123;
    }
    

}