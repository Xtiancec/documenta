<?php
// superadmin_dashboard.php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user' || $_SESSION['user_role'] !== 'adminrh') {
    header("Location: ../login.php");
    exit();
}

require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-chart-bar"></i> Mi Panel de Información</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item">Administrador de Recursos Humanos</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span><img src="../assets/images/icon/income.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Income</h6>
                                        <h2 class="m-t-0">953,000</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span><img src="../assets/images/icon/expense.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Expense</h6>
                                        <h2 class="m-t-0">236,000</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span><img src="../assets/images/icon/assets.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Assets</h6>
                                        <h2 class="m-t-0">987,563</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center"><span class="lstick m-r-20"></span><img src="../assets/images/icon/staff.png" alt="Income" /></div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Staff</h6>
                                        <h2 class="m-t-0">987,563</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Sales overview chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title m-b-5"><span class="lstick"></span>Sales Overview </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-theme stats-bar">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="p-20 active">
                                            <h6 class="text-white">Total Sales</h6>
                                            <h3 class="text-white m-b-0">$10,345</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="p-20">
                                            <h6 class="text-white">This Month</h6>
                                            <h3 class="text-white m-b-0">$7,589</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="p-20">
                                            <h6 class="text-white">This Week</h6>
                                            <h3 class="text-white m-b-0">$1,476</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="sales-overview2" class="p-relative" style="height:360px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- visit charts-->
                    <!-- ============================================================== -->
                    <div class="col-lg-3 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><span class="lstick"></span>Visit Separation</h4>
                                <div id="visitor" style="height:290px; width:100%;"></div>
                                <table class="table vm font-14">
                                    <tr>
                                        <td class="b-0">Mobile</td>
                                        <td class="text-right font-medium b-0">38.5%</td>
                                    </tr>
                                    <tr>
                                        <td>Tablet</td>
                                        <td class="text-right font-medium">30.8%</td>
                                    </tr>
                                    <tr>
                                        <td>Desktop</td>
                                        <td class="text-right font-medium">7.7%</td>
                                    </tr>
                                    <tr>
                                        <td>Other</td>
                                        <td class="text-right font-medium">23.1%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Projects of the month -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>Projects of the Month</h4></div>
                                    <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option selected="">January 2017</option>
                                            <option value="1">February 2017</option>
                                            <option value="2">March 2017</option>
                                            <option value="3">April 2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <table class="table vm no-th-brd no-wrap pro-of-month">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Assigned</th>
                                                <th>Name</th>
                                                <th>Priority</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width:50px;"><span class="round"><img src="../assets/images/users/1.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Sunil Joshi</h6><small class="text-muted">Web Designer</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-success label-rounded">Low</span></td>
                                            </tr>
                                            <tr class="active">
                                                <td><span class="round"><img src="../assets/images/users/2.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Andrew</h6><small class="text-muted">Project Manager</small></td>
                                                <td>Real Homes</td>
                                                <td><span class="label label-info label-rounded">Medium</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-success"><img src="../assets/images/users/3.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Bhavesh patel</h6><small class="text-muted">Developer</small></td>
                                                <td>MedicalPro Theme</td>
                                                <td><span class="label label-primary label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-primary"><img src="../assets/images/users/4.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Nirav Joshi</h6><small class="text-muted">Frontend Eng</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-danger label-rounded">Low</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-warning"><img src="../assets/images/users/5.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Micheal Doe</h6><small class="text-muted">Content Writer</small></td>
                                                <td>Helping Hands</td>
                                                <td><span class="label label-success label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-danger"><img src="../assets/images/users/6.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Johnathan</h6><small class="text-muted">Graphic</small></td>
                                                <td>Digital Agency</td>
                                                <td><span class="label label-info label-rounded">High</span></td>
                                            </tr>
                                            <tr>
                                                <td><span class="round round-primary"><img src="../assets/images/users/4.jpg" alt="user" width="50"></span></td>
                                                <td>
                                                    <h6>Nirav Joshi</h6><small class="text-muted">Frontend Eng</small></td>
                                                <td>Elite Admin</td>
                                                <td><span class="label label-danger label-rounded">Low</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Activity widget find scss into widget folder-->
                    <!-- ============================================================== -->
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h4 class="card-title"><span class="lstick"></span>Activity</h4>
                                    <!-- <span class="badge badge-success">9</span> -->
                                    <div class="btn-group ml-auto m-t-10">
                                        <a href="JavaScript:void(0)" class="icon-options-vertical link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-box">
                                <div class="card-body">
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../assets/images/users/2.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">Mark Freeman <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <table class="table vm b-0 m-b-0">
                                                <tr>
                                                    <td class="m-r-10 b-0"><img src="../assets/images/icon/zip.png" alt="user" /></td>
                                                    <td class="b-0">
                                                        <h5 class="m-b-0 font-medium ">Homepage.zip</h5>
                                                        <h6>54 MB</h6></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../assets/images/users/3.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">Emma Smith <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">joined projectname, and invited <a href="javascript:void(0)">@maxcage, @maxcage, @maxcage, @maxcage, @maxcage,+3</a></h6>
                                            <span class="image-list m-t-20">
                                                <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" class="img-circle" alt="user" width="50"></a>
                                                <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" class="img-circle" alt="user" width="50"></a>
                                                <a href="javascript:void(0)"><span class="round round-warning">C</span></a>
                                            <a href="javascript:void(0)"><span class="round round-danger">D</span></a>
                                            <a href="javascript:void(0)">+3</a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../assets/images/users/4.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-0 font-medium">David R. Jones  <span class="text-muted font-14 m-l-10">| &nbsp; 9:30 PM, July 13th</span></h5>
                                            <h6 class="text-muted">uploaded this file </h6>
                                            <span>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="../assets/images/big/img1.jpg" alt="user" width="60"></a>
                                                <a href="javascript:void(0)" class="m-r-10"><img src="../assets/images/big/img2.jpg" alt="user" width="60"></a>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                    <!-- Activity item-->
                                    <div class="activity-item">
                                        <div class="round m-r-20"><img src="../assets/images/users/6.jpg" alt="user" width="50" /></div>
                                        <div class="m-t-10">
                                            <h5 class="m-b-5 font-medium">David R. Jones <span class="text-muted font-14 m-l-10">| &nbsp; 6:30 PM</span></h5>
                                            <h6 class="text-muted">Commented on<a href="javascript:void(0)">Test Project</a></h6>
                                            <p class="m-b-0">It has survived not only five centuries, but also the leap into unchanged.</p>
                                        </div>
                                    </div>
                                    <!-- Activity item-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Blog and website visit -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-4 col-xlg-3">
                        <div class="card">
                            <img class="card-img-top img-responsive" src="../assets/images/big/img1.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h3 class="font-normal">Business development of rules 2017</h3>
                                <span class="label label-info label-rounded">Technology</span>
                                <p class="m-b-0 m-t-20">Titudin venenatis ipsum aciat. Vestibulum ullamcorper quam. nenatis ipsum ac feugiat. Ibulum ullamcorper</p>
                                <div class="d-flex m-t-20">
                                    <button class="btn p-l-0 btn-link ">Read more</button>
                                    <div class="ml-auto align-self-center">
                                        <a href="javascript:void(0)" class="link m-r-10"><i class="fa fa-heart-o"></i></a>
                                        <a href="javascript:void(0)" class="link m-r-10"><i class="fa fa-share-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xlg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h4 class="card-title"><span class="lstick"></span>Website Visit</h4>
                                    <ul class="list-inline m-b-0 ml-auto">
                                        <li>
                                            <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Site A view</h6> </li>
                                        <li>
                                            <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10"></i>Site B view</h6> </li>
                                    </ul>
                                </div>
                                <div class="text-center m-t-30">
                                    <div class="btn-group " role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-secondary">PAGEVIEWS</button>
                                        <button type="button" class="btn btn-sm btn-secondary">REFERRALS</button>
                                    </div>
                                </div>
                                <div class="website-visitor p-relative m-t-30" style="width:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Twitter facebook and mail boxes -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="stats">
                                        <h1 class="text-white">3257+</h1>
                                        <h6 class="text-white">Twitter Followers</h6>
                                        <button class="btn btn-rounded btn-outline btn-light m-t-10 font-14">Check list</button>
                                    </div>
                                    <div class="stats-icon text-right ml-auto"><i class="fa fa-twitter display-5 op-3 text-dark"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="stats">
                                        <h1 class="text-white">6509+</h1>
                                        <h6 class="text-white">Facebook Likes</h6>
                                        <button class="btn btn-rounded btn-outline btn-light m-t-10 font-14">Check list</button>
                                    </div>
                                    <div class="stats-icon text-right ml-auto"><i class="fa fa-facebook display-5 op-3 text-dark"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="stats">
                                        <h1 class="text-white">9062+</h1>
                                        <h6 class="text-white">Subscribe</h6>
                                        <button class="btn btn-rounded btn-outline btn-light m-t-10 font-14">Check list</button>
                                    </div>
                                    <div class="stats-icon text-right ml-auto"><i class="fa fa-envelope display-5 op-3 text-dark"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Tod do and profile -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6 col-xlg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h4 class="card-title"><span class="lstick"></span>To Do list</h4>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="pull-right btn btn-circle btn-success" data-toggle="modal" data-target="#myModal"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- To do list widgets -->
                                <!-- ============================================================== -->
                                <div class="to-do-widget m-t-20">
                                    <!-- .modal for add task -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add Task</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Task name</label>
                                                            <input type="text" class="form-control" placeholder="Enter Task Name"> </div>
                                                        <div class="form-group">
                                                            <label>Assign to</label>
                                                            <select class="custom-select form-control pull-right">
                                                                <option selected="">Sachin</option>
                                                                <option value="1">Sehwag</option>
                                                                <option value="2">Pritam</option>
                                                                <option value="3">Alia</option>
                                                                <option value="4">Varun</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info m-b-10">
                                                <input type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
                                                <label for="inputSchedule" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span> <span class="label label-rounded label-danger pull-right">Today</span></label>
                                            </div>
                                            <ul class="assignedto">
                                                <li><img src="../assets/images/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave"></li>
                                                <li><img src="../assets/images/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jessica"></li>
                                                <li><img src="../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                                <li><img src="../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                            </ul>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                                                <label for="inputBook" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span><span class="label label-primary label-rounded pull-right">1 week </span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputCall" name="inputCheckboxesCall">
                                                <label for="inputCall" class=""> <span>Give Purchase report to</span> <span class="label label-info label-rounded pull-right">Yesterday</span> </label>
                                            </div>
                                            <ul class="assignedto">
                                                <li><img src="../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                                <li><img src="../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                            </ul>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputForward" name="inputCheckboxesForward">
                                                <label for="inputForward" class=""> <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span> <span class="label label-warning label-rounded pull-right">2 weeks</span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>
