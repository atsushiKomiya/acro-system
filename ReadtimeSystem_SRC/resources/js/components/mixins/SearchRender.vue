<script>
  export default {
    methods: {
      betterRender(listKey,deployList) {
        const self = this;
        self[listKey] = [];
        const list = deployList;
        const ite = function*() {
          // NOTE: 20アイテムづつsetTimeoutでレンダリング
          while (true) {
            const items = list.splice(0, 20); // Get items 20 by 20
            if (items.length <= 0) break;
            yield setTimeout(() => {
              for (let len = items.length, i = 0; i < len; i++) {
                const item = items[i]
                self[listKey].push(item);
              }
              ite.next();
            });
          }
        }();
        ite.next();
      },
    }
  }
</script>