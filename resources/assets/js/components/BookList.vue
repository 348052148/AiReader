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
                    <td>
                        <p>{{item.book_id}}</p>
                        <a style="cursor: pointer;" @click="editBooks(item)">编辑</a>
                    </td>
                    <td>{{item.classify_id}}</td>
                    <td>{{item.title}}</td>
                    <td><img width="100" height="125" :src="item.cover"></td>
                    <td>{{item.author}}</td>
                    <td>
                            <p>{{item.detail}}</p>
                    </td>
                    <td>{{item.status}}</td>
                    <td> <router-link :to="'/chapters?book_id='+item.book_id">内容</router-link></td>
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


        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">编辑</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label >书籍名称</label>
                                <input type="text" class="form-control" v-model="selectBookInfo.title" name="title" placeholder="书籍名称">
                            </div>
                            <div class="form-group">
                                <label >书籍作者</label>
                                <input type="text" v-model="selectBookInfo.author" class="form-control" placeholder="作者">
                            </div>
                            <div class="form-group">
                                <label >书籍封面</label>
                                <div class="row">
                                    <input class="col-sm-9" type="file" name="cover" >
                                    <p class="help-block col-sm-3">
                                        <img width="50" height="60" :src="selectBookInfo.cover" />
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >详情</label>
                                <textarea class="form-control" name="detail" v-model="selectBookInfo.detail"  rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label >状态</label>
                                <select class="form-control" v-model="selectBookInfo.status" name="status">
                                    <option value="连载">连载</option>
                                    <option value="全本">全本</option>
                                </select>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" @click="postSaveBook(selectBookInfo)" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" >编辑</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" @click="postDeleteBook(deleteBookId)" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>

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
                ],
                selectBookInfo:{},

                deleteBookId:'',
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
            },
            editBooks(book){
                this.selectBookInfo = book;
                $('#edit').modal({})
            },
            deleteBooks(book_id){
                this.deleteBookId = book_id;
                $('#delete').modal({})
            },
            postSaveBook(bookData){
                axios.default.post(
                    "http://127.0.0.1:8000/admin/books/"+bookData.book_id,
                    bookData).then((res) => {
                        if (res.status == 200) {
                            $('#edit').modal('hide')
                        }
                })
            },
            postDeleteBook(book_id){
                axios.default.delete(
                    "http://127.0.0.1:8000/admin/books/"+book_id,
                    bookData).then((res) => {
                    if (res.status == 200) {
                        $('#delete').modal('hide')
                    }
                })
            }
        }

    }
</script>
