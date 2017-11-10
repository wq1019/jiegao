<template>
  <div class="article_item">
    <router-link :to="{name: 'editArticle', params: {id: article.id}}" v-if="article.cover_url" class="cover" :style="{'background-image': `url(${article.cover_url})`}"></router-link>
    <div class="body" :class="{'no_cover': article.cover_url === null}">
      <h3><router-link :to="{name: 'editArticle', params: {id: article.id}}"><Tag class="tag" v-if="article.top" color="red">置顶</Tag><Tag class="tag" v-if="article.status === 'draft'" color="green">草稿</Tag>{{article.title}}</router-link><a v-if="article.preview_url" :href="article.preview_url" target="_blank" class="pre_view">预览</a></h3>
      <p class="describe">{{article.excerpt}}</p>
      <UserWeight v-if="article.user.data.length !== 0" :id="article.user.data.id" :avatar_url="article.user.data.avatar_url" :nick_name="article.user.data.nick_name"></UserWeight>
      <span class="info"><HoverableTime :time="article.published_at"></HoverableTime></span>
      <span class="info">阅读：{{article.views_count}}</span>
      <span class="info">分类：{{article.category.data.cate_name}}</span>
    </div>
    <div class="option">
      <Button :type="isTrashed ? 'success' : 'primary'" size="large" @click="$emit(isTrashed ? 'restore' : 'edit', article.id)">{{isTrashed ? '还原' : '编辑'}}</Button>
      <Button type="error" size="large" shape="circle" icon="android-delete" @click="$emit('del', article.id)"></Button>
    </div>
  </div>
</template>

<script>
import UserWeight from './UserWeight.vue';
import HoverableTime from './HoverableTime.vue';
export default {
  name: 'articleItem',
  props: {
    isTrashed: Boolean,
    article: Object
  },
  components: { UserWeight, HoverableTime }
};
</script>
<style lang="less" scoped>
.article_item{
  border-radius: 4px;
  padding: 10px;
  background-color: #fff;
  overflow: hidden;
  box-shadow: rgba(0, 0, 0, 0.05) 0 1px 3px;
  position: relative;
  margin-bottom: 15px;
  .cover{
    float: left;
    border-radius: 5px;
    width: 170px;
    height: 110px;
    background-size: cover;
  }
  &:hover a.pre_view{
    display: block!important;
  }
  .body{
    padding-left: 190px;
    padding-right: 200px;
    &.no_cover{
      padding-left: 0;
    }
    h3, a:not(.pre_view){
      display: block;
      margin-right: 80px;
      color: #525659;
      overflow: hidden;
      text-overflow: ellipsis;
      font-weight: normal;
      white-space: nowrap;
      font-size: 18px;
      position: relative;
      >.tag:last-child{
        margin-right: 10px;
      }
      >.pre_view{
        display: none;
        position: absolute;
        right: 30px;
        top: 4px;
        margin: 0;
        font-size: 10px;
      }
    }
    .describe{
      margin: 5px 0 3px 0;
      color: #999;
      height: 38px;
      overflow: hidden;
    }
    .info{
      line-height: 30px;
      margin-right: 15px;
      float: right;
      >.icon{
        font-size: 16px;
        margin-right: 5px;
      }
    }
  }
  .option{
    position: absolute;
    top: 47px;
    right: 30px;
    button:first-child{
      margin-right: 20px;
    }
  }
}
</style>
