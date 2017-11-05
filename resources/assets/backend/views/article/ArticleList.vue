<template>
  <div class="article_list">
    <ListWrapper :loading.sync="showPlaceholder" ref="list" :title="title" :queryName="`posts?include=user,category&category_id=${categoryId}&status=${status}${showTrashed ? '&only_trashed=true' : ''}`">
      <span slot="option"><Button @click="$router.push({name: 'addArticle'})" icon="plus-round" type="primary">添加</Button></span>
      <template slot-scope="props">
        <div class="option_list">
          <RadioGroup v-model="status" type="button">
              <Radio label="all">全部</Radio>
              <Radio label="publish">已发布</Radio>
              <Radio label="draft">草稿</Radio>
          </RadioGroup>
          <Button size="small" @click="showTrashed = !showTrashed" class="trashed_btn" :type="showTrashed ? 'success' : 'warning'">{{showTrashed ? '退出回收站' : '显示回收站'}}</Button>
          <Select @on-change="categoryChange" v-model="categoryId" style="width:200px">
            <Option :value="0">全部分类文章</Option>
            <Option v-for="item in categories" :value="item.id" :key="item.id">{{item.indent_str}}{{ item.cate_name }}</Option>
          </Select>
        </div>
        <template v-if="showPlaceholder">
          <div v-for="n in 3" :key="n" class="content_placeholder_wrapper">
            <content-placeholder :rows="placeholderRows"></content-placeholder>
          </div>
        </template>
        <ArticleItem v-else :isTrashed="showTrashed" @restore="restore" @edit="id => $router.push({name: 'editArticle', params: { id }})" @del="del" :key="article.id" v-for="article in props.data" :article="article"></ArticleItem>
        <NoData v-if="props.data.length === 0 && !showPlaceholder"></NoData>
      </template>
    </ListWrapper>
  </div>
</template>
<script>
import ArticleItem from '../../components/ArticleItem.vue';
import ListWrapper from '../../components/ListWrapper.vue';
import recycleBin from '../../mixins/recycleBin';
import NoData from '../../components/NoData.vue';
import ContentPlaceholder from 'vue-content-placeholder';
export default {
  components: { ArticleItem, ListWrapper, NoData, ContentPlaceholder },
  mixins: [ recycleBin ],
  mounted () {
    let cid = Number(this.$route.params.id);
    if (!isNaN(cid)) {
      this.categoryId = cid;
    }
    this.$http.get('categories/visual_output', {
      params: {
        type: 'post'
      }
    }).then(res => {
      this.categories = res.data.data;
    });
  },
  methods: {
    categoryChange (curId) {
      this.$router.push({name: 'articleList', params: {id: curId}});
    }
  },
  computed: {
    title () {
      let prefix = this.showTrashed ? '回收站' : '文章列表';
      let currentCate = this.categories.find(item => item.id === this.categoryId);
      if (currentCate) {
        return `${prefix}(${currentCate.cate_name})`;
      }
      return prefix;
    },
    mixinConfig () {
      return {
        title: '文章',
        action: 'posts'
      };
    }
  },
  data () {
    return {
      showPlaceholder: false,
      showTrashed: false,
      status: 'all',
      categories: [],
      categoryId: 0,
      colums: [
        {
          title: '标题',
          key: 'title'
        },
        {
          title: '作者信息',
          key: 'author_info'
        },
        {
          title: '描述',
          key: 'excerpt'
        },
      ],
      placeholderRows: [
        {
          height: '27px',
          boxes: [['10px', '170px'], ['20px', 1.6]]
        },
        {
          height: '10px',
          boxes: [['10px', '170px']]
        },
        {
          height: '10px',
          boxes: [['10px', '170px'], ['20px', 3]]
        },
        {
          height: '3px',
          boxes: [['10px', '170px']]
        },
        {
          height: '10px',
          boxes: [['10px', '170px'], ['20px', 3]]
        },
        {
          height: '20px',
          boxes: [['10px', '170px']]
        },
        {
          height: '25px',
          boxes: [['10px', '170px'], ['20px', '60px'], ['410px', '115px']]
        },
      ]
    };
  }
};
</script>

<style lang="less" scoped>
.article_list{
  .content_placeholder_wrapper{
    padding: 10px 0;
    background-color: #fff;
    box-shadow: rgba(0, 0, 0, 0.05) 0 1px 3px;
    margin-bottom: 15px;
  }
  .option_list{
    margin-bottom: 15px;
    .trashed_btn{
      margin-left: 10px;
      margin-right: 20px;
    }
  }
}
</style>
