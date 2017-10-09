下载laravel{
composer create-project laravel/laravel=5.2.* --prefer-dist
}
路由{
基本路由{
Route::get('/index',function(){
return view('welcome');
})
}
高级路由{
Route::get('index','IndexController@index');
}
路由分组{
//Route::get('admin/index','Admin\IndexController@index');
//admin/index 						===>>名称 				前缀==>>admin
//Admin\IndexController@index 		===>>命名空间控制器		命名空间==>>Admin
Route::group(['prefix'=>'名称的前缀','namespace'=>'命名空间'],function(){
Route::get('index','IndexController@index');
Route::get('admin','IndexController@admin');
Route::get('del','IndexController@del');
});
}
资源路由{
Route::resource('名称new','控制器名称');
}
中间件{			//验证是否登录
//创建middleware	php artisan make:middleware 文件名[LoginAdmin]
//http下找到mideeleware文件夹，看是否生成LoginAdmin文件
//http下Kernel.php复制$routeMiddleware的数组下添加		'新名login'=>App\Http\Middleware\LoginAdmin::Class,
Route::group(['prefix'=>'名称的前缀','namespace'=>'命名空间','middleware'=>['新名login']],function(){
Route::get('index','IndexController@index');
Route::get('admin','IndexController@admin');
Route::get('del','IndexController@del');
});
//测试==>>在Middleware下heandel的方法里面，先echo 然后return
}
跳转页面{
return tedirect('空间/方法');
}
}
制作控制器{
php artisan make:controller IndexController
}
创建后台{
先创建后台文件夹Admin
php artisan make:controller Admin\IndexController
路由书写{
Route::get('admin/index','Admin\IndexController@index');
} //echo '小福贵儿';
}
表单提交数据{
{{csrf_field()}}
}
增删改查{
接收数据{
Input::all();				接收所有数据
$request->all();			接收所有数据
$request->input('字段');	接收一个数据
$request->字段;				接收一个数据
$request->except('字段');	过滤一个数据
$request->except(['字段1','字段2']);	过滤多个数据
}
查找数据{
$data = DB::table('表')->get();		//查找所有数据
$data = DB::table('表')->where('字段','条件')->first();		//查找1条
}
添加数据，获取id{
$id = DB::table('表')->insertGetId($data);
}
修改数据{
$res = DB::table('表')->where('字段','条件')->update($data);
}
删除数据{
$res=Model::destroy($id);
}
}
数据分页{
$data = DB::table('表')->paginate(5);
//模板中
{!! $data->links!!}
//使用浮动
<style>
    li{
        float:left; 			//横向
    padding-left:20px;		//间隔
    }
</style>
}
分页降序{
$data=Model::orderBy('排序的字段','排序的方法【desc】')->paginate(条数);
}
判断是否是post提交{
$request->isMethod('post');
}
加密{
\Crypt::encrypt("字符");
}
解密{
\Crypt::decrypt("字符");
}
根目录下composer.json的autoload中加入类文件{
"files": [
"文件夹/文件"
]
composer update
}
登录验证{
$res = DB::table('表名')->where(['字段'=>值],['字段2'=>值2])->first();
}
跳转页面{
header("refresh:设置秒数:url=".路径);		//过时跳
redirect('路径');							//立即跳
}
提交验证规则{
$input=$request->all();
$return=[
'字段'=>'required|alpha|max:6',		//不为空且为字母且最长是6
]
$validator=validator::make($input,$retrn);
//通过
$validator->passes();
//失败
return back()->withErrors($validaror);		//返回失败的信息,整体是个$errors对象
//view页面展示错误信息
@if(count($errors))
@foreach($errors->all() as $error)
{{ $error }}
@endforeach
@endif
}
设置中文报错{
$input=$request->all();
$return=[
'字段'=>'required|alpha|max:6',		//不为空且为字母且最长是6
];
$massger=[
'字段.required'=>'*******',
'字段.alpha'=>'*******',
'字段.max'=>'*******',
];
$validator=validator::make($input,$retrn,$massger);
//通过
$validator->passes();
//失败
return back()->withErrors($validaror);		//返回失败的信息,整体是个$errors对象
//view页面展示错误信息
@if(count($errors))
@foreach($errors->all() as $error)
{{ $error }}
@endforeach
@endif
}
添加数据{
//新建model,添加固定的表名
protected $table='表名';
public $timestamps=false;
//控制器实例化
$tab = new Tab();	Tab是model
$tab->字段=$request->字段;
$tab->save();
}
添加数组形式的{
//新建model
//固定的表名
protected $table='表名';
//设置主键id
protected $primaryKey='id';
public $timestamps=false;
//黑白名单设置
protected $fillable=['字段'];		//白名单
protected $guarded=['字段','···']	//黑名单
//控制器实例化
$data=array();			//不为空的数组
Tat::create($data);		//保存入库
}
错误提示{
return back()->with('errors','失败');
}

