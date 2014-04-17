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
                <pre>
                <code class="html">
                    <p>&lt;?php<br /><br />return array(<br />&nbsp;&nbsp;&nbsp; 'base_path' =&gt; dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',<br />&nbsp;&nbsp;&nbsp; 'title' =&gt; 'Framework baru',<br />&nbsp;&nbsp;&nbsp; /*<br />&nbsp;&nbsp;&nbsp;&nbsp; * base url for domain and path <br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; 'base_url' =&gt; 'http://localhost/framework/app/',<br />&nbsp;&nbsp;&nbsp; /* default router where the default class and action should be called<br />&nbsp;&nbsp;&nbsp;&nbsp; * controller is a class name<br />&nbsp;&nbsp;&nbsp;&nbsp; * action is a function name<br />&nbsp;&nbsp;&nbsp;&nbsp; * <br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; 'router' =&gt; array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'controller' =&gt; 'welcome',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'parameter' =&gt; array()),<br />&nbsp;&nbsp;&nbsp; /*<br />&nbsp;&nbsp;&nbsp;&nbsp; * modules is an autoload mechanism<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; 'modules' =&gt; array('Config' =&gt; 'core\Config',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'Router' =&gt; 'core\Router',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'Logger' =&gt; 'core\Logger'),<br />&nbsp;&nbsp;&nbsp; /*<br />&nbsp;&nbsp;&nbsp;&nbsp; * database configuration<br />&nbsp;&nbsp;&nbsp;&nbsp; * we can use multiple database connection at same time<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; 'database' =&gt; array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /*<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * the first database configuration<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'db' =&gt; array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'driver' =&gt; 'mysql',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'host' =&gt; 'localhost',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'database' =&gt; 'mydb',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'username' =&gt; 'root',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'password' =&gt; '1234',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'port' =&gt; '3306',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'persistent' =&gt; false,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'autoinit' =&gt; true,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; /* second database<br />&nbsp;&nbsp;&nbsp;&nbsp; * <br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />//"db" =&gt; array()<br />&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; 'encoding' =&gt; 'UTF-8',<br />&nbsp;&nbsp;&nbsp; 'timezone' =&gt; 'UTC'<br />);<br /><br /></p>
                </code>
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
                <pre>
                <code class="html">
                    <p>&lt;?php<br /><br />namespace app\controllers;<br /><br />/**<br />&nbsp;* Description of welcome<br />&nbsp;* @package name<br />&nbsp;* @author masfu<br />&nbsp;* @copyright (c) 2014, Masfu Hisyam<br />&nbsp;*/<br /><br />use app\core as app;<br />use app\models as model;<br /><br />class welcome extends app\Controller {<br />&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; /**<br />&nbsp;&nbsp;&nbsp;&nbsp; * constructor<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; public function __construct() {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; }<br />&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; /**<br />&nbsp;&nbsp;&nbsp;&nbsp; * index page<br />&nbsp;&nbsp;&nbsp;&nbsp; * @access public<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; public function index() {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $this-&gt;display("welcome\index.php");<br />&nbsp;&nbsp;&nbsp; }<br />&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; /**<br />&nbsp;&nbsp;&nbsp;&nbsp; * method before execution<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp; public function beforeExecute() {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; }<br /><br />&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; /**<br />&nbsp;&nbsp;&nbsp;&nbsp; * method after execution<br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; public function afterExcetion(){<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; }<br />}<br /><br /></p>
                </code>
                </pre>
                atau bisa kita menggunakan custom controller dengan membuat class di <code>\app\core\Controller.php</code> 
                yang merupakan turunan dari class <code class="html">/system/core/BaseController.php</code> dengan mengextends nya kita bisa membuat layouting sederharna
            </div>
            <div class="bs-docs-section">
                <h2 id="model" class="page-header">Model</h2>
                Model merepresentasikan struktur data dari aplikasi kita. Pada intinya, di model ini memiliki banyak fungsi yang terfokus untuk melakukan retrieve, insert, update, dan delete record dari database.
                <br>
                <pre>
                <code class="html">
                    <p>&lt;?php<br /><br />/*<br />&nbsp;* To change this license header, choose License Headers in Project Properties.<br />&nbsp;* To change this template file, choose Tools | Templates<br />&nbsp;* and open the template in the editor.<br />&nbsp;*/<br /><br />/**<br />&nbsp;* Description of User<br />&nbsp;* @package name<br />&nbsp;* @author masfu<br />&nbsp;* @copyright (c) 2014, Masfu Hisyam<br />&nbsp;*/<br /><br />namespace app\models;<br /><br />use \system\db as db;<br /><br /><br />class User extends db\ActiveRecord {<br /><br />&nbsp;&nbsp;&nbsp; private $db;<br /><br />&nbsp;&nbsp;&nbsp; public function __construct() {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<br />&nbsp;&nbsp;&nbsp; }<br /><br />&nbsp;&nbsp;&nbsp; public function getSantri() {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $db = \Sby::instance()-&gt;db-&gt;createDb();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $hasil = $db-&gt;query('select * from santri');<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $data = $hasil-&gt;fetchArray();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; foreach ($data as $value) {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; //&nbsp;&nbsp; print_r($value);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }<br />&nbsp;&nbsp;&nbsp; }<br /><br />}<br /><br /></p>
                </code>
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
                <pre>
                <code class="html">
                    <p>&nbsp;&nbsp;&nbsp; 'database' =&gt; array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /*<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * the first database configuration<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; */<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'db' =&gt; array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'driver' =&gt; 'mysql',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'host' =&gt; 'localhost',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'database' =&gt; 'mydb',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'username' =&gt; 'root',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'password' =&gt; '1234',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'port' =&gt; '3306',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'persistent' =&gt; false,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 'autoinit' =&gt; true,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; /* second database<br />&nbsp;&nbsp;&nbsp;&nbsp; * <br />&nbsp;&nbsp;&nbsp;&nbsp; */<br />//"db" =&gt; array()</p>
                </code>
                </pre>
                untuk menambah database lagi kita bisa menambah array lagi di bawah dengan nama misalnya db2
            </div>
            <div class="bs-docs-section">
                <h2 id="db_query" class="page-header">Menulis Query</h2>
                <br>
                <pre>
                <code class="html">
                    <p>$db = \Sby::instance()-&gt;db-&gt;createDb();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $hasil = $db-&gt;query('select * from santri');<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $data = $hasil-&gt;fetchArray();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; foreach ($data as $value) {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print_r($value);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }</p>
                </code>
                </pre>
                atau kita bisa langsung membuat koneksi ke db dengan class <code class="html">\system\db\SqlProvider</code>
            </div>
            <div class="bs-docs-section">
                <h2 id="db_result" class="page-header">Menampilkan data dari database</h2>
                <pre>
                <code class="html">
                    <p>$hasil = $db-&gt;query('select * from santri');<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $data = $hasil-&gt;fetchArray();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; foreach ($data as $value) {<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; print_r($value);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; }</p>
                </code>
                </pre>
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
                            <li><a href="#db_result">Menampilkan data</a></li>
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
