Graduation_Project_only
=======================

系统代码部署：
该项目适合运行于Apache服务器，首先打开Apache服务器的rewrite_module模块，若项目部署于www目录下的子目录，需要先打开.htaccess文件在"/index.php"字符串前增加"/子目录的名字"。

数据库部署：
在MySQL中新建数据库，导入findpo.sql。

最后打开app/config/config.php文件设置网站的访问URL，打开app/config/database.php文件设置已建数据库的名字和数据库帐号、密码。

更多CI框架的配置可参考：
http://codeigniter.org.cn/user_guide/toc.html