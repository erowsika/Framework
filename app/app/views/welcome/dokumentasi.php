<div class="bs-docs-header" id="content">
    <div class="container">
        <h1>Instalasi Framework</h1>
        <p>Cara menginstall dan menggunakan API dasar</p>
        <div id="carbonads-container"><div class="carbonad"><div id="azcarbon"></div>
            </div></div>

    </div>
</div>

<div class="container bs-docs-container">

    <div class="row">
        <div class="col-md-9" role="main">
            <div class="bs-docs-section">
                <h1 id="persyaratan" class="page-header">Persyaratan installasi</h1>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-9">
                        <ol>
                            <li>
                                Web server : Apache, nginx
                            </li>
                            <li>
                                PHP Version : 5.3 ke atas
                            </li>
                            <li>
                                PDO Module
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- Getting started
  ================================================== -->
            <div class="bs-docs-section">
                <h1 id="instalasi" class="page-header">Instalasi</h1>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-9">
                        <ol>
                            <li>
                                Download framework terbaru dari website <a href="">Download</a>
                            </li>
                            <li>Unzip di folder untuk mendapat source codenya.
                            </li>
                            <li>Lalu kemudian upload di webserver anda.</li>
                            <li>Buka <code>app/config/application.php</code> dan rubah beberapa setting:
                                <ul>
                                    <li>Atur default base url </li>
                                    <li>Atur <code>base_url</code> sesuai dengan root url di folder anda</li>
                                </ul>
                            </li>
                            <li>Kemudian buka di web browser</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Community
            ================================================== -->
            <div class="bs-docs-section">
                <h1 id="konfigurasi" class="page-header">Konfigurasi</h1>
                <p>Semua konfigurasi dasar dari framework ini ada di file <br> <code>app/config/application.php</code></p>
                <pre class="prettyprint">
                    <xmp>
                        

return array(
    'base_path' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'title' => 'Framework baru',
    /*
     * base url for domain and path 
     */
    'base_url' => 'http://hisyam-pc/framework/app/',
    /*
     * modules is an autoload mechanism
     */
    'moduls' => array('auth' => 'app\core\Auth'),
    'router' => array(
        /**
         * default controller
         */
        'default_controller' => 'Welcome',
        /**
         * add suffix at the end of controller class
         */
        'controller_suffix' => 'Controller',
        /**
         * parameter of url pattern
         */
        'parameter' => array(
            'controller' => '(\w+)',
            'action' => '(\w+)',
            'id' => '(\d+)',
            'page' => '(\d+)'
        )
    ),
    /*
     * database configuration
     * we can use multiple database connection at same time
     */
    'database' => array(
        /*
         * the first database configuration
         */
        'mysql' => array(
            'driver' => 'mysqli',
            'host' => 'localhost',
            'database' => 'posyandu',
            'username' => 'root',
            'password' => '1234',
            'port' => '3306',
            'persistent' => false,
            'autoinit' => true,
        ),
        'pgsql' => array(
            'driver' => 'pgsql',
            'host' => 'localhost',
            'database' => 'hr',
            'username' => 'postgres',
            'password' => '1234',
            'persistent' => false,
            'autoinit' => true,
        ),
        'pdo' => array(
            'driver' => 'pdo',
            'dsn' => 'sqlite:/mydb.sq3',
            'username' => 'postgres',
            'password' => '1234',
            'persistent' => false,
            'autoinit' => true,
        ),
        'oci' => array(
            'driver' => 'oci',
            'dsn' => 'orcl',
            'username' => 'hr',
            'password' => 'hr',
            'port' => '1521',
            'persistent' => false,
            'autoinit' => true,
        ),
        'mongo' => array(
            'driver' => 'mongodb',
            'document' => 'test',
            'host' => 'localhost',
            'username' => '',
            'password' => '',
            'autoinit' => true,
        ),
    ),
    'encoding' => 'UTF-8',
    /**
     * set time zone
     */
    'timezone' => 'UTC',
    /**
     * set session name
     */
    'session' => array(
        'login_url' => '',
        /**
         * set session name
         */
        'session_name' => 'framework',
        /**
         * session time expiration
         * default 2 weeks
         */
        'session_expire' => 3600 * 24 * 14),
    'cache' => array('driver' => 'file')
);


                    </xmp>
                </pre>
            </div>

            <div class="bs-docs-section">
                <h1 id="routing" class="page-header">Routing</h1>
                <p>Untuk konfigurasi routing, maka yang perlu diubah adalah file  <br> <code>app/config/router.php</code></p>
                <pre class="prettyprint">
                    <xmp>
      array(
        /**
         * 
         */
        array('GET', '/admin', 'admin\Login@index'),
        /**
         * 
         */
        array('GET', '/admin/<controller>', 'app\controllers\admin\<controller>@index'),
        /**
         * 
         */
        array('GET|POST', '/admin/<controller>/<action>', 'admin\<controller>@<action>'),
        /**
         * 
         */
        array('GET|POST', '/admin/<controller>/<action>/<id>', 'admin\<controller>@<action>\<id>'),
        /**
         * default controller
         */
        'default_controller' => 'Beranda',
        /**
         * add suffix at the end of controller class
         */
        'controller_suffix' => 'Controller',
        /**
         * parameter of url pattern
         */
        'parameter' => array(
            'controller' => '(\w+)',
            'action' => '(\w+)',
            'id' => '(\d+)',
            'page' => '(\d+)'
        )
    ),
                    </xmp>
                </pre>
            </div>    
            
            <div class="bs-docs-section">
                <h1 id="caching" class="page-header">Caching</h1>
                <p>Cache berguna untuk menyimpan sementara data dari database atau halaman website utuh</p>
                <pre class="prettyprint">
                    <xmp>
//set data
App::instance()->cache->set('key','value', 5);  

//get data
App::instance()->cache->get('key');
</xmp>
                </pre>
            </div>
            <div class="bs-docs-section">
                <h1 id="mvc" class="page-header">Model View Controller</h1>
                Model-View-Controller atau MVC adalah sebuah metode untuk membuat sebuah aplikasi dengan memisahkan data (Model) dari tampilan (View) dan cara bagaimana memprosesnya (Controller). Dalam implementasinya kebanyakan framework dalam aplikasi website adalah berbasis arsitektur MVC.[1] MVC memisahkan pengembangan aplikasi berdasarkan komponen utama yang membangun sebuah aplikasi seperti manipulasi data, antarmuka pengguna, dan bagian yang menjadi kontrol dalam sebuah aplikasi web.
                sources <a href="http://id.wikipedia.org/wiki/MVC">http://id.wikipedia.org/wiki/MVC</a>
            </div>
            <div class="bs-docs-section">
                <h2 id="controller" class="page-header">Controller</h2>
                Membuat controller sederhana yaitu bisa dengan mengextends class <code class="html">/system/core/BaseController.php</code>
                <br>
                <pre class="prettyprint">
                    <xmp>
namespace app\controllers;

/**
 * Description of welcome
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */
use app\core\Controller;

class WelcomeController extends Controller {

    /**
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * index page
     * @access public
     */
    public function index() {
      return $this->display("welcome\index.php");
    }
}
                    </xmp>
                </pre>
                atau bisa kita menggunakan custom controller dengan membuat class di <code>\app\core\Controller.php</code> 
                yang merupakan turunan dari class <code class="html">/system/core/BaseController.php</code> dengan mengextends nya kita bisa membuat layouting sederharna
            </div>
            <div class="bs-docs-section">
                <h2 id="model" class="page-header">Model</h2>
                Model merepresentasikan struktur data dari aplikasi kita. Pada intinya, di model ini memiliki banyak fungsi yang terfokus untuk melakukan retrieve, insert, update, dan delete record dari database.
                <br>
                <pre class="prettyprint">
                    <xmp>
                        /**
 * Description of User
 * @package name
 * @author masfu
 * @copyright (c) 2014, Masfu Hisyam
 */

namespace app\models;

use system\db\Model;

class Users extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function rules() {
        return array(
            array(
                'label' => 'name',
                'field' => 'name',
                'rules' => 'type:string|min:0|required:true|trim:true'),
             array(
                'label' => 'email',
                'field' => 'name',
                'rules' => 'type:email|min:0|required:true|trim:true'),
            );
    }
}

                </xmp>
                </pre>
            </div>
            <div class="bs-docs-section">
                <h2 id="view" class="page-header">View</h2>
                View adalah bagian yang diperlihatkan pada user. Jadi, halaman web yang ditampilkan di browser adalah code yang kita tuliskan di bagian view. Sebuah view dapat berupa file penuh, atau hanya potongan seperti header atau footer.
            </div>


            <div class="bs-docs-section">
                <h1 id="database" class="page-header">Database</h1>
                Framework ini mendukung beberapa database seperi mysql, pgsql, oracle, monggodb, PDO dan juga bisa melakukan multi connection dalam satu waktu
            </div>
            <div class="bs-docs-section">
                <h2 id="db_konfigurasi" class="page-header">Konfigurasi database</h2>
                Untuk mengatur koneksi database kita bisa mengedit file <code class="html">\app\config\application.php</code>
                <br>
                <pre class="prettyprint">
                <xmp>
       'database' => array(
        /*
         * the first database configuration
         */
        'db' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'mydb',
            'username' => 'root',
            'password' => '1234',
            'port' => '3306',
            'persistent' => false,
            'autoinit' => true,
        ),
    /* second database
     *
     */
//"db" => array()
</xmp>
                </pre>
                untuk menambah database lagi kita bisa menambah array lagi di bawah dengan nama misalnya db2
            </div>
            <div class="bs-docs-section">
                <h2 id="db_query" class="page-header">Menulis Query</h2>
                <br>
                <pre class="prettyprint">
                <xmp>
$db = \Sby::instance()->db->createDb();
$result = $db->query('select * from users');
foreach ($hasil->fetchArray() as $value) {
    var_dump($value);
}
    </xmp>
                </pre>
                atau kita bisa langsung membuat koneksi ke db dengan class <code class="html">\system\db\SqlProvider</code>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bs-docs-sidebar hidden-print" role="complementary">
                <ul class="nav bs-docs-sidenav">
                    <li>
                        <a href="#persyaratan">Persyaratan</a>
                    </li>
                    <li>
                        <a href="#instalasi">Instalasi</a>
                    </li>
                    <li>
                        <a href="#konfigurasi">Konfigurasi Framework</a>
                    </li>
                    <li>
                        <a href="#routing">Routing</a>
                    </li>
                    <li>
                        <a href="#caching">Caching</a>
                    </li>
                    <li>
                        <a href="#mvc">Model View Controller</a>
                        <ul class="nav">
                            <li><a href="#controller">Controller</a></li>
                            <li><a href="#model">Model</a></li>
                            <li><a href="#view">View</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#database">Database</a>
                        <ul class="nav">
                            <li><a href="#db_konfigurasi">Konfigurasi</a></li>
                            <li><a href="#db_query">Menulis query</a></li>
                     </ul>
                    </li>
                </ul>
                <a class="back-to-top" href="#top">
                    Back to top
                </a>
            </div>
        </div>
    </div>

</div>
