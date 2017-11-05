<template>
  <div class="role_list">
    <ListWrapper ref="list" title="角色列表" :queryName="mixinConfig.action">
      <span slot="option"><Button @click="$router.push({name: 'addRole'})" icon="plus-round" type="primary">添加</Button></span>
      <template slot-scope="props">
        <TTable :columns="colums" :data="props.data" />
      </template>
    </ListWrapper>
  </div>
</template>

<script>
import TTable from '../../components/t-table';
import ListWrapper from '../../components/ListWrapper.vue';
import HoverableTime from '../../components/HoverableTime.vue';
import delMixin from '../../mixins/del';
export default {
  components: { TTable, ListWrapper, HoverableTime },
  computed: {
    mixinConfig () {
      return {
        title: '角色',
        action: 'roles'
      };
    }
  },
  mixins: [ delMixin ],
  data () {
    return {
      colums: [
        {
          title: '角色',
          key: 'name'
        },
        {
          title: '角色名',
          key: 'display_name'
        },
        {
          title: '描述',
          type: 'gray',
          key: 'description'
        },
        {
          title: '排序',
          key: 'order'
        },
        {
          title: '创建日期',
          key: 'created_at',
          render: (h, params) => {
            return h(HoverableTime, {
              props: {time: params.created_at}
            });
          },
          width: '100px'
        },
        {
          title: '操作',
          key: 'action',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'primary',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.$router.push({name: 'editRole', params: {id: params.id}});
                  }
                }
              }, '编辑'),
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => { this.del(params.id); }
                },
              }, '删除')
            ]);
          }
        }
      ]
    };
  }
};
</script>

<style scoped lang="less">

</style>
