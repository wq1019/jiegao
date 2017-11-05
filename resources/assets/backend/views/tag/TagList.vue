<template>
  <div class="role_list">
    <ListWrapper ref="list" title="标签列表" :queryName="mixinConfig.action">
      <span slot="option"><Button @click="$router.push({name: 'addTag'})" icon="plus-round" type="primary">添加</Button></span>
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
        title: '标签',
        action: 'tags'
      };
    }
  },
  mixins: [ delMixin ],
  data () {
    return {
      colums: [
        {
          title: '标签明',
          key: 'name'
        },
        {
          title: 'slug',
          key: 'slug'
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
                    this.$router.push({name: 'editTag', params: {id: params.id}});
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
