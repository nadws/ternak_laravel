<!-- Main Sidebar Container -->
<?php  $user_id = Auth::user()->id;?>
<?php $sub_m = DB::table('tb_sub_menu')
                        ->where('url', Route::current()->getName())
                        ->first();  ?>
<?php if (empty($sub_m->url)) : ?>

<?php else : ?>
<?php $per = DB::table('tb_permission')
                                ->where('permission', $sub_m->id_sub_menu)
                                ->where('id_user', $user_id)
                                ->first() ?>
<?php if (empty($per->id_user)) : ?>
<script>
    window.location.href = '{{ route('login') }}';
</script>
<?php else : ?>
<?php endif ?>
<?php endif ?>
<aside class="main-sidebar elevation-4" style="background-color: white">
    @php
    $id_lokasi = Request::get('acc');
    @endphp
    <!-- Brand Logo -->

    <a href="" class="brand-link" style=" background: white; color: #787878;">
        <img src="{{ asset('assets') }}/menu/img/agrilaras.png" alt="AdminLTE Logo" class="brand-image img-circle"
            style="opacity: .8">

        <span class="brand-text font-weight-bold" style="color: #121F3E">CV.AgriLaras</span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">
        <hr>
        <!-- Sidebar Menu -->
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Home</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }} ">
                        <i class="nav-icon {{ Request::is('dashboard') ? 'active' : '' }} fas fa-tachometer-alt "></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @php
                $headline = DB::table('tb_headline')->get();
                @endphp

                @foreach ($headline as $h)
                <li class="nav-header">{{$h->nm_headline}}</li>
                @php
                $id_user = Auth::user()->id;
                $sub = DB::table('tb_sub_menu')
                ->where('url', Route::current()->getName())
                ->first();
                @endphp
                <?php if(empty($sub->url)): ?>

                <?php 
                $menu = DB::select(
                "SELECT a.id_user, b.url, c.id_menu, c.icon, c.menu
                FROM tb_permission AS a
                LEFT JOIN tb_sub_menu AS b ON b.id_sub_menu = a.permission
                LEFT JOIN tb_menu AS c ON c.id_menu = b.id_menu
                WHERE a.id_user ='$id_user' and c.id_head_line = $h->id_head_line
                GROUP BY b.id_menu
                order by c.urutan ASC
                "
                )  ?>
                <?php $i = 1; foreach ($menu as $m): ?>

                <li class="nav-item  {{$i++}}">
                    <a href="#" class="nav-link ">
                        <i class=" nav-icon <?= $m->icon ?>"></i>
                        <p>
                            <?= $m->menu ?>
                            <i class="right fas fa-angle-left" style="vertical-align: middle"></i>
                        </p>
                    </a>
                    <?php $menu_p = DB::select(
                                    DB::raw(
                                        "SELECT a.id_user, b.url, b.sub_menu, c.id_menu, c.icon, c.menu
                                            FROM tb_permission AS a
                                            LEFT JOIN tb_sub_menu AS b ON b.id_sub_menu = a.permission
                                            LEFT JOIN tb_menu AS c ON c.id_menu = b.id_menu
                                            WHERE a.id_user ='$id_user' and b.id_menu = '$m->id_menu'
                                        "
                                    ),
                                )  ?>


                    <ul class="nav nav-treeview">
                        @foreach ($menu_p as $m)
                        <li class="nav-item">
                            <a href="{{ route($m->url) }}" class="nav-link {{Request::is($m->url) ? 'active' : ''}}">
                                <i class="{{Request::is($m->url) ? 'active' : ''}} far fa-circle nav-icon"></i>
                                <p>{{$m->sub_menu}}</p>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </li>
                <?php endforeach ?>
                <?php else:?>

                <?php 
               
                $menu = DB::select(
                    
                        "SELECT a.id_user, b.url, c.id_menu, c.icon, c.menu
                        FROM tb_permission AS a
                        LEFT JOIN tb_sub_menu AS b ON b.id_sub_menu = a.permission
                        LEFT JOIN tb_menu AS c ON c.id_menu = b.id_menu
                        WHERE a.id_user ='$id_user' and c.id_head_line = $h->id_head_line
                        GROUP BY b.id_menu
                        order by c.urutan ASC
                        "
                 
                )  ?>
                <?php foreach ($menu as $m): ?>

                <?php 
                        $permission2 =  DB::selectOne(
                            DB::raw(
                                "SELECT a.id_user, a.permission, b.sub_menu, b.url, b.id_menu
                                FROM tb_permission AS a
                                LEFT JOIN tb_sub_menu AS b ON b.id_sub_menu = a.permission
                                WHERE a.id_user ='$id_user' AND a.permission = '$sub->id_sub_menu'
                                "
                            ),
                        ) 
                        
                        
                        ?>
                <li class="nav-item {{ $permission2->id_menu == $m->id_menu  ? 'menu-open' : ''}} ">
                    <a href="#" class="nav-link {{$permission2->id_menu == $m->id_menu ? 'active' : ''}}">
                        <i
                            class="{{$permission2->id_menu == $m->id_menu ? 'active' : ''}} nav-icon <?= $m->icon ?>"></i>
                        <p>
                            <?= $m->menu ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <?php $menu_p = DB::select(
                        DB::raw(
                            "SELECT a.id_user, b.url, b.sub_menu, c.id_menu, c.icon, c.menu
                                FROM tb_permission AS a
                                LEFT JOIN tb_sub_menu AS b ON b.id_sub_menu = a.permission
                                LEFT JOIN tb_menu AS c ON c.id_menu = b.id_menu
                                WHERE a.id_user ='$id_user' and b.id_menu = '$m->id_menu'
                            "
                        ),
                    )  ?>


                    <ul class="nav nav-treeview">
                        @foreach ($menu_p as $m)
                        <li class="nav-item">
                            <a href="{{ route($m->url) }}" class="nav-link {{Request::is($m->url) ? 'active' : ''}}">
                                <i class="{{Request::is($m->url) ? 'active' : ''}} far fa-circle nav-icon"></i>
                                <p>{{$m->sub_menu}}</p>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </li>
                <?php endforeach ?>
                <?php endif ?>
                @endforeach




                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li class="nav-item">
                        <hr>
                        <button type="submit" class="nav-link btn" style="background: transparent">
                            <i class="nav-icon fas fa-power-off"></i>
                            <p>Logout</p>
                        </button>
                    </li>
                </form>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>