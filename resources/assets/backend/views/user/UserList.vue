<template>
  <div>
    <ListWrapper ref="list" title="用户列表" :queryName="mixinConfig.action + '?include=roles'">
      <span slot="option"><Button @click="$router.push({name: 'addUser'})" icon="plus-round" type="primary">添加</Button></span>
      <template slot-scope="props">
        <TTable :columns="colums" :data="props.data" />
      </template>
    </ListWrapper>
  </div>
</template>
<script>
  import TTable from '../../components/t-table';
  import UserWeight from '../../components/UserWeight.vue';
  import ListWrapper from '../../components/ListWrapper.vue';
  import HoverableTime from '../../components/HoverableTime.vue';
  import delMixin from '../../mixins/del';
  export default {
    components: { TTable, UserWeight, ListWrapper, HoverableTime },
    computed: {
      mixinConfig () {
        return {
          title: '用户',
          action: 'users'
        };
      }
    },
    mixins: [ delMixin ],
    data () {
      return {
        colums: [
          {
            title: '昵称',
            key: 'nick_name',
            render: (h, params) => {
              return h(UserWeight, {
                props: params
              });
            },
            style: {'padding-left': '50px'},
            width: '110px'
          },
          {
            title: '用户名',
            key: 'user_name',
            width: '160px',
          },
          {
            title: 'email',
            key: 'email',
            type: 'gray',
            style: {'text-align': 'left'},
            width: '230px'
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
            title: '状态',
            key: 'locked_at',
            render: (h, params) => {
              const status = params.locked_at === null;
              return h('Tag', {
                props: {color: status ? 'green' : 'red', type: 'border'}
              }, status ? '正常' : '锁定');
            }
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
                      this.$router.push({name: 'editUser', params: {id: params.id}});
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