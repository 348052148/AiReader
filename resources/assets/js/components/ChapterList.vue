<template>
    <table class="table table-bordered table-hover">
        <caption><h3>书籍列表</h3></caption>
        <thead>
        <tr >
            <td>编号</td>
            <td>分类名</td>
            <td>内容</td>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in chapterList">
            <td><p>{{item.index}}</p></td>
            <td>{{item.title}}</td>
            <td><a :href="item.content_link">内容</a></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        mounted() {
            this.getChapterList(this.$route.query['book_id'])
        },
        data() {
            return {
                chapterList:[],
            }
        },
        methods:{
            getChapterList(bookId){
                axios.default.get("http://127.0.0.1:8000/admin/book/"+bookId+"/chapters").then((res) => {
                    this.chapterList = res.data;
                })
            }
        }
    }
</script>