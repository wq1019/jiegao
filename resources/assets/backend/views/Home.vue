<template>
  <div class="home">
    <Menu mode="horizontal" theme="light" class="header">
      <Logo size="small" class="logo"></Logo>
    </Menu>
    <Menu width="220px" class="menu" theme="light" :active-name="currentActiveKey" :open-names="['content', 'user']" @on-select="onSelect">
      <Menu-item class="top_menu_item" name="home"><Icon type="home"></Icon>首页</Menu-item>
      <Submenu name="content">
        <template slot="title">
          <Icon type="ios-paper"></Icon>
          内容管理
        </template>
        <Menu-item name="articleList">文章管理</Menu-item>
        <Menu-item name="columnList">栏目管理</Menu-item>
        <Menu-item name="bannerList">Banner管理</Menu-item>
        <Menu-item name="linkList">链接管理</Menu-item>
        <Menu-item name="tagList">标签管理</Menu-item>
      </Submenu>
      <Submenu name="user">
        <template slot="title">
          <Icon type="ios-people"></Icon>
          用户管理
        </template>
        <Menu-item name="userList">用户列表</Menu-item>
        <Menu-item name="roleList">角色列表</Menu-item>
      </Submenu>
      <Menu-item name="settingList"><Icon type="gear-a"></Icon>站点设置</Menu-item>
    </Menu>
    <div class="content-wrapper height-100p">
      <div class="content">
        <router-view class="router_view"></router-view>
      </div>
    </div>
  </div>
</template>
<script>
import Logo from '../components/Logo.vue';
export default {
  components: { Logo },
  data () {
    return {
      currentActiveKey: this.$route.name
    };
  },
  watch: {
    '$route' () {
      this.currentActiveKey = this.$route.name;
    }
  },
  methods: {
    onSelect (name) {
      this.$nextTick(() => {
        this.$router.push({name});
      });
    },
  }
};
</script>

<style scoped lang="less">
  .home{
    .header, .menu{
      position: fixed;
      top: 0;
      left: 0;
      overflow: hidden;
    }
    .header{
      height: 50px;
      background-color: #fff;
      box-shadow: rgba(0, 0, 0, 0.1) 0 1px 2px;
      z-index: 10;
      right: 0;
      .logo{
        position: absolute;
        left: -65px;
        top: -38px;
      }
    }
    .menu{
      bottom: 0;
      padding-top: 60px;
      z-index: 9;
    }
    .top_menu_item > i{
      margin-right: 12px;
    }
    .content-wrapper{
      padding-top: 50px;
      padding-left: 220px;
      >.content{
        margin: 0 auto;
        width: 1000px;
        >.router_view{
          min-height: 100%;
          width: 980px;
          margin: 0 auto;
          padding-top: 30px;
          padding-bottom: 50px;
        }
      }
    }
  }
</style>
