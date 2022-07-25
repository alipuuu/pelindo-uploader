    <ul class="sidebar-menu " data-widget="tree">
@if (auth()->user()->level==1)
<li class="active"><a href="/dashboard"><i class="fa fa-tachometer"></i> <span>DASHBOARD</span></a></li>
<li class="treeview">
    <a href="#">
    <i class="fa fa-archive"></i> <span>MASTER DATA</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li class="active"><a href="/userr"><i class="fa fa-user "></i> <span>USER</span></a></li>
    <li class="active"><a href="/server"><i class="fa fa-database"></i> <span>SERVER</span></a></li>
    </ul>
    </li>
    <li class="active"><a href="/upload"><i class="fa fa-upload"></i> <span>UPLOAD</span></a></li>
    <li class="active"><a href="/change-password"><i class="fa fa-key"></i> <span>CHANGE PASSWORD</span></a></li>
    {{-- <li class="active"><a href="/cetak-pegawai-form"><i class="fa fa-book"></i> <span>REPORT</span></a></li> --}}
    {{-- <li class="active"><a href="/pelindo"><i class="fa fa-book"></i> <span>PELINDO</span></a></li> --}}
@elseif (auth()->user()->level==2)
    <li class="active"><a href="/dashboard"><i class="fa fa-tachometer"></i> <span>DASHBOARD</span></a></li>
    <li class="active"><a href="/change-password"><i class="fa fa-key"></i> <span>CHANGE PASSWORD</span></a></li>
@endif
    </ul>
