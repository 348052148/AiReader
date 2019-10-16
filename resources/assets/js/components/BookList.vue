<template>
    <div class="container-fluid">
        <table class="table table-bordered table-hover">
            <caption><h3>书籍列表</h3></caption>
            <thead>
                <tr >
                    <td>编号</td>
                    <td>分类</td>
                    <td width="120" >书籍名称</td>
                    <td>封面</td>
                    <td width="120" >书籍作者</td>
                    <td>详情</td>
                    <td>状态</td>
                    <td>章节链接</td>
                    <td>来源</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in bookList">
                    <td><p>{{item.book_id}}</p></td>
                    <td>{{item.classify_id}}</td>
                    <td>{{item.title}}</td>
                    <td><img width="100" height="125" :src="item.cover"></td>
                    <td>{{item.author}}</td>
                    <td>
                            <p>{{item.detail}}</p>
                    </td>
                    <td>{{item.status}}</td>
                    <td><a :href="item.chapter_link">内容</a>></td>
                    <td>{{item.source}}</td>
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
            this.getBooksByPage(1)
        },
        data(){
            return {
                currentPage:1,
                lastPage:1,
                showPages:[],
                bookList:[
                    {
                        bookId:1,
                        title:"仙逆",
                        classify:"修真",
                        author:"耳根",
                        cover:"",
                        detail:"详情",
                        status:"连载",
                        source:"全文网",
                        chapterLink:"",
                    }
                ]
            }
        },
        methods:{
            getBooksByPage(page) {
                axios.default.get("http://127.0.0.1:8000/admin/books/"+page).then((res) => {
                    this.bookList = res.data.data;
                    this.currentPage = res.data.current_page;
                    this.lastPage = res.data.last_page;
                    console.log(res)
                    //分页处理
                    this.showPages = [];
                    if (this.lastPage - this.currentPage <= 10 && this.lastPage - this.currentPage >= 0 ) {
                        for(let i=this.lastPage-10; i <= this.lastPage; i++) {
                            this.showPages.push(i)
                        }
                    }else if(this.currentPage-5 <= 0){
                        let pageLen = this.lastPage > 10 ? 10 : this.lastPage;
                        for(let i=1; i <= pageLen; i++) {
                            this.showPages.push(i)
                        }
                    }else {
                        for(let i=this.currentPage -5; i <= this.currentPage+5; i++) {
                            this.showPages.push(i)
                        }
                    }

                    console.log(this.showPages)
                })
            }
        }

    }
</script>
