<?php
Route::pattern('id', '([0-9]+)');
Route::pattern('name', '(.*)');
Route::get('user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');

Route::namespace('Auth')->group(function(){
    Route::get('login', [ 
        'uses' => 'AuthController@getLogin',
        'as' => 'auth.auth.login'
    ]);
    Route::post('login', [ 
        'uses' => 'AuthController@postLogin',
        'as' => 'auth.auth.login'
    ]);

    Route::get('logout', [ 
        'uses' => 'AuthController@logout',
        'as' => 'auth.auth.logout'
    ]);
});
Route::namespace('Vadmin')->prefix('vadmin')->middleware('auth')->group(function () {
    //core module
    Route::namespace('Core')->prefix('core')->group(function () {

        Route::namespace('Index')->prefix('index')->group(function () {
            Route::get('/', [
                'uses' => 'AciIndexController@index',
                'as' => 'vadmin.core.index.index'
            ]);
        });

        Route::namespace('NapThe')->prefix('napthe')->group(function () {
            Route::get('/index', [
                'uses' => 'AcnIndexController@index',
                'as' => 'vadmin.core.napthe.index'
            ]);
            Route::post('/index', [
                'uses' => 'AcnIndexController@postCard',
                'as' => 'vadmin.core.napthe.index'
            ]);
            Route::get('/callback', [
                'uses' => 'AcnIndexController@callBack',
                'as' => 'vadmin.core.napthe.callback'
            ]);
        });

        Route::namespace('User')->prefix('user')->group(function () {
            Route::get('index', [
                'uses' => 'AcuIndexController@index',
                'as' => 'vadmin.core.user.index'
            ]);
            Route::get('export', [
                'uses' => 'AcuIndexController@export',
                'as' => 'vadmin.core.user.export'
            ]);

            Route::get('add', [
                'uses' => 'AcuIndexController@getAdd',
                'as' => 'vadmin.core.user.add'
            ]);

            Route::post('add',[
                'uses' => 'AcuIndexController@postAdd',
                'as'   => 'vadmin.core.user.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcuIndexController@del',
                'as'   => 'vadmin.core.user.del'
            ])->middleware('vneauth:admin');

            Route::get('edit/{id}',[
                'uses' => 'AcuIndexController@getEdit',
                'as'   => 'vadmin.core.user.edit'
            ])->middleware('vneauth:admin');
            Route::post('edit/{id}',[
                'uses' => 'AcuIndexController@postEdit',
                'as'   => 'vadmin.core.user.edit'
            ]);

            Route::post('delall',[
                'uses' => 'AcuIndexController@delAll',
                'as'   => 'vadmin.core.user.delall'
            ])->middleware('vneauth:admin');

            Route::get('profile/{id}',[
                'uses' => 'VNEUserController@getProfile',
                'as'   => 'vinaenter.vneuser.profile'
            ]);
            Route::post('profile/{id}',[
                'uses' => 'VNEUserController@postProfile',
                'as'   => 'vinaenter.vneuser.profile'
            ]);
        });



        Route::namespace('Group')->prefix('group')->group(function () {
            Route::get('index', [
                'uses' => 'AcgIndexController@index',
                'as' => 'vadmin.core.group.index'
            ]);

            Route::get('add', [
                'uses' => 'AcgIndexController@getAdd',
                'as' =>   'vadmin.core.group.add'
            ]);

            Route::post('add',[
                'uses' => 'AcgIndexController@postAdd',
                'as'   => 'vadmin.core.group.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcgIndexController@del',
                'as'   => 'vadmin.core.group.del'
            ])->middleware('vneauth:admin');

            Route::get('edit/{id}',[
                'uses' => 'AcgIndexController@getEdit',
                'as'   => 'vadmin.core.group.edit'
            ])->middleware('vneauth:admin');
            Route::post('edit/{id}',[
                'uses' => 'AcgIndexController@postEdit',
                'as'   => 'vadmin.core.group.edit'
            ]);

            Route::post('delall',[
                'uses' => 'AcgIndexController@delAll',
                'as'   => 'vadmin.core.group.delall'
            ])->middleware('vneauth:admin');
        });
        // for cat core
        Route::namespace('Cat')->prefix('cat')->group(function () {
            Route::get('index',[
                'uses' => 'AccIndexController@index',
                'as'   => 'vadmin.core.cat.index'
            ]);

            Route::get('add',[
                'uses' => 'AccIndexController@getAdd',
                'as'   => 'vadmin.core.cat.add'
            ]);
            Route::post('add',[
                'uses' => 'AccIndexController@postAdd',
                'as'   => 'vadmin.core.cat.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AccIndexController@del',
                'as'   => 'vadmin.core.cat.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AccIndexController@getEdit',
                'as'   => 'vadmin.core.cat.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AccIndexController@postEdit',
                'as'   => 'vadmin.core.cat.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AccIndexController@delAll',
                'as'   => 'vadmin.core.cat.delall'
            ]);
            Route::get('export',[
                'uses' => 'AccIndexController@export',
                'as'   => 'vadmin.core.cat.export'
            ]);
        });
        // SLIDE HOME
        Route::namespace ('Slide')->prefix('slide')->group(function () {
            Route::get('index', [
                'uses' => 'AcsIndexController@index',
                'as' => 'vadmin.core.slide.index',
            ]);

            Route::get('add', [
                'uses' => 'AcsIndexController@getAdd',
                'as' => 'vadmin.core.slide.add',
            ]);

            Route::post('add', [
                'uses' => 'AcsIndexController@postAdd',
                'as' => 'vadmin.core.slide.add',
            ]);

            Route::get('del/{id}', [
                'uses' => 'AcsIndexController@del',
                'as' => 'vadmin.core.slide.del',
            ]);

            Route::get('edit/{id}', [
                'uses' => 'AcsIndexController@getEdit',
                'as' => 'vadmin.core.slide.edit',
            ]);

            Route::post('edit/{id}', [
                'uses' => 'AcsIndexController@postEdit',
                'as' => 'vadmin.core.slide.edit',
            ]);
        });

        // for article core
        Route::namespace('Article')->prefix('article')->group(function () {
            Route::get('index',[
                'uses' => 'AcaIndexController@index',
                'as'   => 'vadmin.core.article.index'
            ]);

            Route::get('add',[
                'uses' => 'AcaIndexController@getAdd',
                'as'   => 'vadmin.core.article.add'
            ]);
            Route::post('add',[
                'uses' => 'AcaIndexController@postAdd',
                'as'   => 'vadmin.core.article.add'
            ]);
            Route::get('getdetail',[
                'uses' => 'AcaIndexController@getDetailAuto',
                'as'   => 'vadmin.core.article.getDetail'
            ]);

            Route::post('getdetail',[
                'uses' => 'AcaIndexController@postDetailAuto',
                'as'   => 'vadmin.core.article.getDetail'
            ]);
            Route::get('getdetailtext',[
                'uses' => 'AcaIndexController@getDetailText',
                'as'   => 'vadmin.core.article.getDetailText'
            ]);

            Route::get('tags',[
                'uses' => 'AcaIndexController@AddTags',
                'as'   => 'vadmin.core.article.AddTags'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcaIndexController@del',
                'as'   => 'vadmin.core.article.del'
            ]);

            Route::get('edit/{id}/{page}',[
                'uses' => 'AcaIndexController@getEdit',
                'as'   => 'vadmin.core.article.edit'
            ]);
            Route::post('edit/{id}/{page}',[
                'uses' => 'AcaIndexController@postEdit',
                'as'   => 'vadmin.core.article.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AcaIndexController@delAll',
                'as'   => 'vadmin.core.article.delall'
            ]);
            Route::post('activeall',[
                'uses' => 'AcaIndexController@ActiveAll',
                'as'   => 'vadmin.core.article.activeall'
            ]);
            Route::post('disall',[
                'uses' => 'AcaIndexController@DisAll',
                'as'   => 'vadmin.core.article.disall'
            ]);
            Route::post('changeCat',[
                'uses' => 'AcaIndexController@changeCat',
                'as'   => 'vadmin.core.article.changeCat'
            ]);

            Route::get('search',[
                'uses' => 'AcaIndexController@search',
                'as'   => 'vadmin.core.article.search'
            ]);
        });
        // for product cat core
        Route::namespace('PCat')->prefix('pcat')->group(function () {
            Route::get('index',[
                'uses' => 'AcpcIndexController@index',
                'as'   => 'vadmin.core.pcat.index'
            ]);
            Route::get('export',[
                'uses' => 'AcpcIndexController@export',
                'as'   => 'vadmin.core.pcat.export'
            ]);

            Route::get('add',[
                'uses' => 'AcpcIndexController@getAdd',
                'as'   => 'vadmin.core.pcat.add'
            ]);
            Route::post('add',[
                'uses' => 'AcpcIndexController@postAdd',
                'as'   => 'vadmin.core.pcat.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcpcIndexController@del',
                'as'   => 'vadmin.core.pcat.del'
            ]);

            Route::get('url/{id}',[
                'uses' => 'AcpcIndexController@getCLink',
                'as'   => 'vadmin.core.pcat.caturl'
            ]);
            Route::post('url/{id}',[
                'uses' => 'AcpcIndexController@postCLink',
                'as'   => 'vadmin.core.pcat.caturl'
            ]);
            Route::get('edit/{id}',[
                'uses' => 'AcpcIndexController@getEdit',
                'as'   => 'vadmin.core.pcat.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcpcIndexController@postEdit',
                'as'   => 'vadmin.core.pcat.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AcpcIndexController@delAll',
                'as'   => 'vadmin.core.pcat.delall'
            ]);
        });
        // for product core
        Route::namespace('Product')->prefix('product')->group(function () {
            Route::get('index',[
                'uses' => 'AcpIndexController@index',
                'as'   => 'vadmin.core.product.index'
            ]);

            Route::get('add',[
                'uses' => 'AcpIndexController@getAdd',
                'as'   => 'vadmin.core.product.add'
            ]);
            Route::post('add',[
                'uses' => 'AcpIndexController@postAdd',
                'as'   => 'vadmin.core.product.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcpIndexController@del',
                'as'   => 'vadmin.core.product.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AcpIndexController@getEdit',
                'as'   => 'vadmin.core.product.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcpIndexController@postEdit',
                'as'   => 'vadmin.core.product.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AcpIndexController@delAll',
                'as'   => 'vadmin.core.product.delall'
            ]);

            Route::get('search',[
                'uses' => 'AcpIndexController@search',
                'as'   => 'vadmin.core.product.search'
            ]);
            Route::post('uploadImage',[
                'uses' => 'AcpIndexController@postImages',
                'as'   => 'vadmin.core.product.postImages'
            ]);

            Route::get('htmldom',[
                'uses' => 'AcpIndexController@getDom',
                'as'   => 'vadmin.core.product.htmldom'
            ]);
            Route::post('htmldom',[
                'uses' => 'AcpIndexController@postDom',
                'as'   => 'vadmin.core.product.htmldom'
            ]);
        });
        // for product core
        Route::namespace('Thuonghieu')->prefix('thuonghieu')->group(function () {
            Route::get('index',[
                'uses' => 'ActhIndexController@index',
                'as'   => 'vadmin.core.thuonghieu.index'
            ]);

            Route::get('add',[
                'uses' => 'ActhIndexController@getAdd',
                'as'   => 'vadmin.core.thuonghieu.add'
            ]);
            Route::post('add',[
                'uses' => 'ActhIndexController@postAdd',
                'as'   => 'vadmin.core.thuonghieu.add'
            ]);

            Route::get('del/{id}',[
                'uses' => 'ActhIndexController@del',
                'as'   => 'vadmin.core.thuonghieu.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'ActhIndexController@getEdit',
                'as'   => 'vadmin.core.thuonghieu.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'ActhIndexController@postEdit',
                'as'   => 'vadmin.core.thuonghieu.edit'
            ]);
            Route::post('delall',[
                'uses' => 'ActhIndexController@delAll',
                'as'   => 'vadmin.core.thuonghieu.delall'
            ]);

            
        });
        Route::namespace('Sim')->prefix('sim')->group(function () {
            Route::get('index',[
                'uses' => 'AcsIndexController@index',
                'as'   => 'vadmin.core.sim.index'
            ]);
            Route::get('add',[
                'uses' => 'AcsIndexController@getAdd',
                'as'   => 'vadmin.core.sim.add'
            ]);
            Route::post('add',[
                'uses' => 'AcsIndexController@postAdd',
                'as'   => 'vadmin.core.sim.add'
            ]);
            Route::get('edit/{id}',[
                'uses' => 'AcsIndexController@getEdit',
                'as'   => 'vadmin.core.sim.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcsIndexController@postEdit',
                'as'   => 'vadmin.core.sim.edit'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcsIndexController@del',
                'as'   => 'vadmin.core.sim.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AcsIndexController@getEdit',
                'as'   => 'vadmin.core.sim.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcsIndexController@postEdit',
                'as'   => 'vadmin.core.sim.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AcsIndexController@delAll',
                'as'   => 'vadmin.core.sim.delall'
            ]);

            Route::get('import',[
                'uses' => 'AcsIndexController@getImport',
                'as'   => 'vadmin.core.sim.import'
            ]);
            Route::post('import',[
                'uses' => 'AcsIndexController@postImport',
                'as'   => 'vadmin.core.sim.import'
            ]);

            Route::get('export', [
                'uses' => 'AcsIndexController@export',
                'as' => 'vadmin.core.sim.export'
            ]);

            
        });
        Route::namespace('Donhang')->prefix('donhang')->group(function () {
            Route::get('index',[
                'uses' => 'AcdIndexController@index',
                'as'   => 'vadmin.core.donhang.index'
            ]);
            Route::get('add',[
                'uses' => 'AcdIndexController@getAdd',
                'as'   => 'vadmin.core.donhang.add'
            ]);
            Route::post('add',[
                'uses' => 'AcdIndexController@postAdd',
                'as'   => 'vadmin.core.donhang.add'
            ]);
            Route::get('edit/{id}',[
                'uses' => 'AcdIndexController@getEdit',
                'as'   => 'vadmin.core.donhang.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcdIndexController@postEdit',
                'as'   => 'vadmin.core.donhang.edit'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcdIndexController@del',
                'as'   => 'vadmin.core.donhang.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AcdIndexController@getEdit',
                'as'   => 'vadmin.core.donhang.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcdIndexController@postEdit',
                'as'   => 'vadmin.core.donhang.edit'
            ]);
            Route::post('delall',[
                'uses' => 'AcdIndexController@delAll',
                'as'   => 'vadmin.core.donhang.delall'
            ]);
        });
        // for about core
        Route::namespace('About')->prefix('about')->group(function () {
            Route::get('index',[
                'uses' => 'AcaIndexController@index',
                'as'   => 'vadmin.core.about.index'
            ]);
            Route::get('edit/{id}',[
                'uses' => 'AcaIndexController@getEdit',
                'as'   => 'vadmin.core.about.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcaIndexController@postEdit',
                'as'   => 'vadmin.core.about.edit'
            ]);
        });

        // for contact core
        Route::namespace('Contact')->prefix('contact')->group(function () {
            Route::get('index',[
                'uses' => 'AccIndexController@index',
                'as'   => 'vadmin.core.contact.index'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AccIndexController@del',
                'as'   => 'vadmin.core.contact.del'
            ]);

            Route::post('delall',[
                'uses' => 'AccIndexController@delAll',
                'as'   => 'vadmin.core.contact.delall'
            ]);

            Route::get('search',[
                'uses' => 'AccIndexController@search',
                'as'   => 'vadmin.core.contact.search'
            ]);

            Route::get('view/{id}',[
                'uses' => 'AccIndexController@view',
                'as'   => 'vadmin.core.contact.view'
            ]);
        });

    

        // for Comment core
        Route::namespace('Comment')->prefix('comment')->group(function () {
            Route::get('index',[
                'uses' => 'AccIndexController@index',
                'as'   => 'vadmin.core.comment.index'
            ]);

            Route::get('parent/{id}',[
                'uses' => 'AccIndexController@parent',
                'as'   => 'vadmin.core.comment.parent'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AccIndexController@del',
                'as'   => 'vadmin.core.comment.del'
            ]);

            Route::post('delall',[
                'uses' => 'AccIndexController@delAll',
                'as'   => 'vadmin.core.comment.delall'
            ]);
            Route::get('search',[
                'uses' => 'AccIndexController@search',
                'as'   => 'vadmin.core.comment.search'
            ]);
        });

        // for adsposition core
        Route::namespace('AdsPosition')->prefix('ads-position')->group(function () {
            Route::get('index',[
                'uses' => 'AcaIndexController@index',
                'as'   => 'vadmin.core.adsposition.index'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcaIndexController@del',
                'as'   => 'vadmin.core.adsposition.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AcaIndexController@getEdit',
                'as'   => 'vadmin.core.adsposition.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcaIndexController@postEdit',
                'as'   => 'vadmin.core.adsposition.edit'
            ]);

            Route::get('add',[
                'uses' => 'AcaIndexController@getAdd',
                'as'   => 'vadmin.core.adsposition.add'
            ]);
            Route::post('add',[
                'uses' => 'AcaIndexController@postAdd',
                'as'   => 'vadmin.core.adsposition.add'
            ]);
        });

        // for advertisement core
        Route::namespace('Advertisement')->prefix('ads')->group(function () {
            Route::get('index',[
                'uses' => 'AcaIndexController@index',
                'as'   => 'vadmin.core.ads.index'
            ]);

            Route::get('parent/{id}',[
                'uses' => 'AcaIndexController@parent',
                'as'   => 'vadmin.core.ads.parent'
            ]);

            Route::get('del/{id}',[
                'uses' => 'AcaIndexController@del',
                'as'   => 'vadmin.core.ads.del'
            ]);

            Route::get('edit/{id}',[
                'uses' => 'AcaIndexController@getEdit',
                'as'   => 'vadmin.core.ads.edit'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcaIndexController@postEdit',
                'as'   => 'vadmin.core.ads.edit'
            ]);

            Route::get('add',[
                'uses' => 'AcaIndexController@getAdd',
                'as'   => 'vadmin.core.ads.add'
            ]);
            Route::post('add',[
                'uses' => 'AcaIndexController@postAdd',
                'as'   => 'vadmin.core.ads.add'
            ]);
        });

        Route::namespace('ApiAccesstrade')->prefix('accesstrade')->group(function () {
            Route::get('index',[
                'uses' => 'AcaaIndexController@index',
                'as'   => 'vadmin.core.accesstrade.index'
            ]);
            Route::get('chiendich',[
                'uses' => 'AcaaIndexController@chiendich',
                'as'   => 'vadmin.core.accesstrade.chiendich'
            ]);
            Route::get('saveCD',[
                'uses' => 'AcaaIndexController@saveCD',
                'as'   => 'vadmin.core.accesstrade.savecd'
            ]);
            Route::post('edit/{id}',[
                'uses' => 'AcaaIndexController@edit',
                'as'   => 'vadmin.core.accesstrade.edit'
            ]);
            Route::get('khuyenmai/{m}',[
                'uses' => 'AcaaIndexController@getKhuyenmai',
                'as'   => 'vadmin.core.accesstrade.khuyenmai'
            ]);
            Route::post('khuyenmai/{m}',[
                'uses' => 'AcaaIndexController@postKhuyenmai',
                'as'   => 'vadmin.core.accesstrade.khuyenmai'
            ]);
            Route::get('top-products',[
                'uses' => 'AcaaIndexController@getTop',
                'as'   => 'vadmin.core.accesstrade.topproducts'
            ]);
            Route::post('top-products',[
                'uses' => 'AcaaIndexController@postTop',
                'as'   => 'vadmin.core.accesstrade.topproducts'
            ]);
            Route::get('datafeeds',[
                'uses' => 'AcaaIndexController@getDatafeeds',
                'as'   => 'vadmin.core.accesstrade.datafeeds'
            ]);
            Route::post('datafeeds',[
                'uses' => 'AcaaIndexController@postDatafeeds',
                'as'   => 'vadmin.core.accesstrade.datafeeds'
            ]);

            Route::get('activechiendich',[
                'uses' => 'AcaaIndexController@activeStatus',
                'as'   => 'vadmin.core.accesstrade.activechiendich'
            ]);
            Route::get('findSaveSate',[
                'uses' => 'AcaaIndexController@findSaveSate',
                'as'   => 'vadmin.core.accesstrade.findSaveSate'
            ]);
            
        });

    }); // end core
});

//for public

Route::namespace('Vpublic')->group(function () {
    Route::get('/create-captcha', [
        'uses' => 'PCaptchaController@create',
        'as' => 'vpublic.core.pccindex.create',
    ]);

    Route::post('/captcha', [
        'uses' => 'PCaptchaController@captchaValidate',
        'as' => 'vpublic.core.pccindex.captcha',
    ]);

    Route::get('/refreshcaptcha', [
        'uses' => 'PCaptchaController@refreshCaptcha',
        'as' => 'vpublic.core.pccindex.refreshCaptcha',
    ]);
    
    Route::namespace('Core')->group(function () {
        Route::get('/', [
            'uses' => 'PcindexController@index',
            'as'   => 'vpublic.core.pcindex.index'
        ]);
        Route::get('/blog/{cat}', [
            'uses' => 'PcindexController@Blog',
            'as'   => 'vpublic.core.pcblog.index'
        ]);
        Route::get('/single/{code}.html', [
            'uses' => 'PcindexController@singleDetail',
            'as'   => 'vpublic.core.pcsingle.index'
        ]);
        Route::get('/lien-he', [
            'uses' => 'PcindexController@contact',
            'as'   => 'vpublic.core.pccontact.index'
        ]);
        Route::post('/lien-he', [
            'uses' => 'PcindexController@postContact',
            'as'   => 'vpublic.core.pccontact.index'
        ]);
        Route::get('/{gridcat}', [
            'uses' => 'PcindexController@gridCat',
            'as'   => 'vpublic.core.pcgridcat.index'
        ]);
       
        Route::get('/{cat}/{tour}.html', [
            'uses' => 'PcindexController@detail',
            'as'   => 'vpublic.core.pcdetail.index'
        ]);
       

    });
});


//FOR AJAX
Route::namespace('Vajax\Vadmin\Core')->prefix('ajax')->group(function (){
    Route::namespace('Article')->prefix('ajax')->group(function (){
        Route::prefix('article')->middleware('auth')->group(function (){
            Route::get('active-article',[
                'uses' => 'AcaIndexController@activeStatus',
                'as'   => 'vadmin.core.article.activestatus'
            ]);
            Route::get('saveTinAuto',[
                'uses' => 'AcaIndexController@saveTinAuto',
                'as'   => 'vadmin.core.article.saveTinAuto'
            ]);
            Route::get('getDetailEdit',[
                'uses' => 'AcaIndexController@getDetailEdit',
                'as'   => 'vadmin.core.article.getDetailEdit'
            ]);
            Route::get('getPosts',[
                'uses' => 'AcaIndexController@getPosts',
                'as'   => 'vadmin.core.article.getPosts'
            ]);
            Route::get('detailtext',[
                'uses' => 'AcaIndexController@detailtext',
                'as'   => 'vadmin.core.article.detailtext'
            ]);
             
        });
    });
    Route::namespace('Thuonghieu')->prefix('ajax')->group(function (){
        Route::prefix('thuonghieu')->middleware('auth')->group(function (){
            Route::get('active-thuonghieu',[
                'uses' => 'ActhIndexController@activeStatus',
                'as'   => 'vadmin.core.thuonghieu.activestatus'
            ]);
        });
    });

    Route::namespace ('Slide')->prefix('slide')->group(function () {
        Route::prefix('slide')->middleware('auth')->group(function () {
            Route::get('active-slide', [
                'uses' => 'AcsIndexController@activeStatus',
                'as' => 'vadmin.core.slide.activestatus',
            ]);
            Route::get('searchArticle', [
                'uses' => 'AcsIndexController@searchArticle',
                'as' => 'vadmin.core.slide.searchArticle',
            ]);
            Route::get('getData', [
                'uses' => 'AcsIndexController@getData',
                'as' => 'vadmin.core.slide.getData',
            ]);
        });
    });

    Route::namespace('Cat')->prefix('ajax')->group(function (){
        Route::prefix('cat')->middleware('auth')->group(function (){
            Route::get('active-cat',[
                'uses' => 'AccIndexController@activeStatus',
                'as'   => 'vadmin.core.cat.activecat'
            ]);
        });
    });
    Route::namespace('Product')->prefix('ajax')->group(function (){
        Route::prefix('product')->middleware('auth')->group(function (){
            Route::get('active-product',[
                'uses' => 'AcpIndexController@activeStatus',
                'as'   => 'vadmin.core.product.activestatus'
            ]);
        });
    });

    Route::namespace('PCat')->prefix('ajax')->group(function (){
        Route::prefix('pcat')->middleware('auth')->group(function (){
            Route::get('active-pcat',[
                'uses' => 'AcpcIndexController@activeStatus',
                'as'   => 'vadmin.core.pcat.activecat'
            ]);
        });
    });

    Route::namespace('User')->prefix('ajax')->group(function (){
        Route::prefix('user')->middleware('auth')->group(function (){
            Route::get('active-user',[
                'uses' => 'AcuIndexController@activeUser',
                'as'   => 'vadmin.core.user.activeuser'
            ]);
        });
    });

    Route::namespace('Comment')->prefix('ajax')->group(function (){
        Route::prefix('comment')->middleware('auth')->group(function (){
            Route::get('active-comment',[
                'uses' => 'AccIndexController@activeStatus',
                'as'   => 'vadmin.core.comment.activestatus'
            ]);
        });
    });
    Route::namespace('Sim')->prefix('ajax')->group(function (){
        Route::prefix('sim')->middleware('auth')->group(function (){
            Route::get('active-sim',[
                'uses' => 'AcsIndexController@activeSim',
                'as'   => 'vadmin.core.sim.activesim'
            ]);
        });
    });
});
Route::namespace('Vajax\Vpublic')->prefix('ajax')->group(function (){
    Route::namespace('Tour')->group(function (){
        Route::prefix('tour')->group(function (){
            Route::post('datve',[
                'uses' => 'ActIndexController@getDatVe',
                'as'   => 'vadmin.core.tour.datve'
            ]);
             
        });
    });
});

