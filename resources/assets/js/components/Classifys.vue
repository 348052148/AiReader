<template>
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <caption><h3>书籍列表</h3></caption>
            <thead>
            <tr >
                <td>编号</td>
                <td>分类名</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in classifyList">
                <td><p>{{item.classify_id}}</p></td>
                <td>{{item.title}}</td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="page in showPages" :class="{active:page==currentPage}" @click="getBooksByPage(page)" ><a>{{page}}</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getClassifysByPage(1)
        },
        data(){
            return {
                currentPage:1,
                lastPage:1,
                showPages:[],
                classifyList:[

                ]
            }
        },
        methods:{
            getClassifysByPage(page) {
                axios.default.get("http://127.0.0.1:8000/admin/classifys/"+page).then((res) => {
                    this.classifyList = res.data.data;
                    this.currentPage = res.data.current_page;
                    this.lastPage = res.data.last_page;
                    console.log(res)
                    //分页处理
                    this.showPages = [];
                    if (this.lastPage - this.currentPage <= 10 && this.lastPage - this.currentPage > 0 ) {
                        for(let i=this.lastPage-10; i < this.lastPage; i++) {
                            this.showPages.push(i)
                        }
                    }else if(this.currentPage-5 <= 0){
                        let pageLen = this.lastPage > 10 ? 10 : this.lastPage;
                        for(let i=1; i <= pageLen; i++) {
                            this.showPages.push(i)
                        }
                    }else {
                        for(let i=this.currentPage -5; i < this.currentPage+5; i++) {
                            this.showPages.push(i)
                        }
                    }

                    console.log(this.showPages)
                })
            }
        }

    }
</script>