<template>
    <div class="container-fluid">
        <div class="row">
            <nav style="margin-bottom: 2px;" class="navbar navbar-inverse col-sm-12">
                <div class="container-fluid">

                </div>
                <a class="navbar-brand" href="#">爱阅读管理后台</a>
            </nav>
        </div>
        <div class="row">
            <ul class="nav nav-pills nav-stacked col-sm-2 col-lg-2 text-center">
                <li role="presentation" ><a href="#/classify">分类管理</a></li>
                <li role="presentation"><a href="#/books">书籍管理</a></li>
                <li role="presentation"><a href="#/users">用户管理</a></li>
                <li role="presentation"><a href="#/sets">系统配置</a></li>
            </ul>
            <div class="col-sm-10 col-lg-10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components:{},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>