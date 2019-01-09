# BookingFoodLikeAirBnb
A sharing economy vertical SNS platform for local people to provide cooking demonstration and realization./一个为本地人士提供厨艺展示并且能变现的共享经济垂直SNS平台。

larval框架
⽹网站⽬目录结构 根⽬目录
⽬目录
  ⽬目录包含应⽤用程序的核⼼心代码。你应⽤用中⼏几乎所有的类都应该放在
这⾥里里。稍后我们会更更深⼊入地了了解这个⽬目录的细节。
⽬目录
⽬目录包含引导框架并配置⾃自动加载的⽂文件。该⽬目录还包含了了 ⼀一个 cache ⽬目录，存放着框架⽣生成的⽤用来提升性能的⽂文件，⽐比如路路由 和服务缓存⽂文件。
⽬目录
    ⽬目录，顾名思义，包含应⽤用程序所有的配置⽂文件。我们⿎鼓励你
通读这些⽂文件，以便便帮助你熟悉所有可⽤用的选项。
⽬目录
⽬目录包含数据填充和迁移⽂文件。你还可以把它作为 SQLite 数 据库存放⽬目录。
Public ⽬目录
public ⽬目录包含了了⼊入⼝口⽂文件 index.php ，它是进⼊入应⽤用程序的所有请 求的⼊入⼝口点。此⽬目录还包含了了⼀一些你的资源⽂文件(如图⽚片、JavaScript 和 CSS)。
App
App
 Bootstrap
 Bootstrap
 Config
 Config
 Database
 Database
 Resources ⽬目录
resource ⽬目录包含了了视图和未编译的资源⽂文件(如 LESS、SASS 或 JavaScript)。此⽬目录还包含你所有的语⾔言⽂文件。
Routes ⽬目录
routes ⽬目录包含了了应⽤用的所有路路由定义，Laravel 默认包含了了⼏几个路路由 ⽂文件: , ,     和 。
⽂文件包含   放置在   中间件组中的 路路由，它提供会话状态、CSRF 防护和 cookie 加密。如果你的应⽤用不不 提供⽆无状态的、RESTful ⻛风格的 API，则所有的路路由都应该在 web.php ⽂文件中定义。
api.php ⽂文件包含 RouteServiceProvider 放置在 api 中间件组中的 路路由，它提供了了频率限制。这些路路由都是⽆无状态的，所以通过这些路路由 进⼊入应⽤用请求旨在通过令牌进⾏行行身份认证，并且不不能访问会话状态。 console.php ⽂文件是定义所有基于闭包的控制台命令的地⽅方。每个闭 包都被绑定到⼀一个命令实例例并且允许和命令⾏行行 IO ⽅方法进⾏行行简单的交 互。尽管这些⽂文件没有定义 HTTP 路路由，但它也将基于控制台的⼊入⼝口点 (路路由)定义到应⽤用程序中。
channels.php ⽤用来注册你的应⽤用⽀支持的所有的事件⼴广播渠道的地⽅方。
Storage ⽬目录
storage ⽬目录包含编译的 Blade 模板、基于⽂文件的会话和⽂文件缓存、以 及框架⽣生成的其他⽂文件。这个⽬目录被细分成 app 、 framework 和 logs 三个⼦子⽬目录。 app ⽬目录可以⽤用来存储应⽤用⽣生成的任何⽂文件。 framework ⽬目录⽤用来存储框架⽣生成的⽂文件和缓存。最后， logs ⽬目录包 含应⽤用的⽇日志⽂文件。
      web.php
web.php
api.php
console.php
channels.php
 RouteServiceProvider
web
             
  storage/app/public 可以⽤用来存储⽤用户⽣生成的⽂文件，⽐比如需要公开访 问的⽤用户头像。你应该创建⼀一个 的软链接指向这个⽬目 录。你可以直接通过     命令来创建此链 接。
Tests ⽬目录
tests ⽬目录包含⾃自动化测试⽂文件。Laravel 已内置了了 PHPUnit 的测试范 例例供你参考。每个测试类都应该以 作为后缀。你可以使⽤用 phpunit 或者 命令来运⾏行行测试。
Vendor ⽬目录
vendor ⽬目录包含你的 Composer 依赖包。
App ⽬目录 MEALMIR⽹网站控制器器说明
public/storage
php artisan storage:link
  Test
  php vendor/bin/phpunit
   app/Http/Controllers/Admin/ 后台控制器器⽬目录
 ActivityController.php 活动控制器器
AdminUserController.php 后台⽤用户控制器器
 CommentController.php 评论控制器器
 NewsController.php 新闻控制器器
  OrderController.php 订单控制器器
 UserController.php ⽤用户控制器器
 app/Http/Controllers/Web/ 前台控制器器⽬目录
 IndexController.php 内容控制器器
 UserController.php ⽤用户中⼼心控制器器

resources⽬目录
routes⽬目录 routes/web.php 核⼼心路路由⽂文件
