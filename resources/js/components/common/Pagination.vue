<template>

  <div class="ml-auto small">
    <ul class="pagination" role="navigation">

      <li class="page-item" :disabled="! prevPage" @click.prevent="goToPrev">
        <a class="page-link" href rel="prev" aria-label="pagination.previous">&lsaquo;</a>
      </li>

      <li class="page-item" :disabled="true">
        <a class="page-link" rel="current" aria-label="pagination.current">
          {{ paginatonCount }}
        </a>
      </li>

      <li class="page-item" :disabled="! nextPage" @click.prevent="goToNext">
        <a class="page-link" href rel="next" aria-label="pagination.next">&rsaquo;</a>
      </li>

    </ul>
  </div>

</template>

<script>
  export default {
    name: 'Pagination',

    props: ['pageInfo'],

    data() {
      return {
        metaDefault: null,
        linksDefault: {
          first: null, last: null, next: null, prev: null,
        },
        indexName: null,
      };
    },

    computed: {
      meta(){
        let meta = this.pageInfo ? this.pageInfo.meta : this.metaDefault;
        if(meta){
          let { current_page, per_page } = meta;
          this.$emit('start:index', ((current_page - 1) * per_page) + 1);
        }
        return meta;
      },
      links(){
        return this.pageInfo ? this.pageInfo.links : this.linksDefault;
      },
      nextPage() {
        if ( ! this.meta || this.meta.current_page === this.meta.last_page) {
          return;
        }

        return this.meta.current_page + 1;
      },
      prevPage() {
        if ( ! this.meta || this.meta.current_page === 1) {
          return;
        }

        return this.meta.current_page - 1;
      },
      paginatonCount() {
        if ( ! this.meta) {
          return;
        }

        const { current_page, last_page } = this.meta;

        return `${current_page} of ${last_page}`;
      },
      beforeRouteUpdate (to, from, next) {
        this.links = this.meta = null;
      },
    },

    methods: {
      goToNext() {
        this.$router.push({
          query: {
            page: this.nextPage,
          },
        });
      },
      goToPrev() {
        if( ! this.indexName){
          this.indexName = this.pageInfo.index;
        }
        this.$router.push({
          name: this.indexName,
          query: {
            page: this.prevPage,
          }
        });
      },
    }
  }
</script>