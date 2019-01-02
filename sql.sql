create database store charset = UTF8;

create table `store_user`(
`id` int unsigned primary key auto_increment comment '主键',
`phone` int(11) UNIQUE NOT NULL COMMENT '手机号',
`username` varchar(50) not null comment '用户名',
`password` varchar(80) not null comment '密码',
`email` varchar (50) comment '邮箱',
`admin` tinyint(1) default 0 comment '是否为管理员,0不是,1是',
`createtime` datetime comment '创建时间',
`updatetime` datetime comment '更新时间'
)engine=InnoDB charset=UTF8 comment='用户表';

create table `store_category`(
 `id` int unsigned primary key auto_increment comment '主键',
 `cname` varchar(50) not null comment '分类名称',
 `pid` int not null default 0 comment '父id',
 `createtime` datetime comment '创建时间',
 `updatetime` datetime comment '更新时间'
)engine=InnoDB charset=UTF8;

create table `store_product`(
 `id` int unsigned primary key auto_increment comment '主键',
 `title` varchar(50) not null comment '产品名称',
 `price` varchar(10) not null comment '产品价格',
 `saleprice` varchar(10) comment '优惠价格',
 `salenum` int comment '优惠数量',
 `libnum` int unsigned default 0 comment '库存数量',
 `content` text comment '产品描述',
 `cid` int not null default 0 comment '分类id',
 `bid` int not null comment '品牌id',
 `createtime` datetime comment '创建时间',
 `updatetime` datetime comment '更新时间'
)engine=InnoDB charset=UTF8;

create table `store_productimg`(
 `id` int unsigned primary key auto_increment comment '主键',
 `path` varchar(100) not null comment '产品名称',
 `pid` int unsigned comment '产品ID'
)engine=InnoDB charset=UTF8;

create table `store_brand`(
 `id` int unsigned primary key auto_increment comment '主键',
 `bname` varchar(50) not null comment '产品名称',
 `logo` varchar(100) comment '品牌图标',
 `cid` int not null default 0 comment '分类id'
)engine=InnoDB charset=UTF8;



