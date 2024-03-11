<template>
  <div class="filters mt-1 mb-4">
    <TransitionGroup>
      <div v-for="(val, i) in $props.records" :key="i">
        <div v-for="(v, e) in val" :key="e">
          <div v-for="(k, r) in v" :key="e.replace(/[\s-&]+/g, '-')">
            <div
              @click="toggleFilterMain(e.replace(/[\s-&]+/g, '-'))"
              class="toggle-button-main cursor-pointer mb-3"
              :class="'toggle-button-text rounded ' + e.replace(/[\s-&]+/g, '-')"
              role="button"
            >
              <div class="d-flex justify-content-between inter-normal-jaguar-14px text-uppercase">
                <div>{{ e }}</div>
                <div>
                  <small
                    ><i v-if="isActiveMain != e.replace(/[\s-&,]+/g, '-')" class="icofont icofont-caret-left"></i
                  ></small>
                  <small
                    ><i v-if="isActiveMain == e.replace(/[\s-&,]+/g, '-')" class="icofont icofont-caret-down"></i
                  ></small>
                </div>
              </div>
            </div>

            <div v-for="(c, l) in k">
              <div
                :class="isActiveMain === e.replace(/[\s-&]+/g, '-') ? 'collapse show' : 'collapse'"
                :id="e.replace(/[\s-&]+/g, '-')"
              >
                <div class="d-flex justify-content-between items-center">
                  <button
                    @click="toggleFilterSub(l.replace(/[\s-&,]+/g, '-'))"
                    v-if="l != 'tempKeyName'"
                    class="btn btn-link pt-1 pb-1 ps-0 mb-0 toggle-button"
                  >
                    <h5 class="toggle-button-text rounded">
                      <span class="text-capitalize inter-normal-jaguar-14px">{{ l }}</span>
                    </h5>
                  </button>
                  <div>
                    <small
                      ><i
                        v-if="isActiveSub != l.replace(/[\s-&,]+/g, '-') && l != 'tempKeyName'"
                        class="icofont icofont-caret-left"
                      ></i
                    ></small>
                    <small
                      ><i
                        v-if="isActiveSub == l.replace(/[\s-&,]+/g, '-') && l != 'tempKeyName'"
                        class="icofont icofont-caret-down"
                      ></i
                    ></small>
                  </div>
                </div>
                <transition>
                  <div
                    class="ms-1"
                    v-show="isActiveSub === l.replace(/[\s-&,]+/g, '-')"
                    :id="l.replace(/[\s-&,]+/g, '-')"
                    :aria-labelledby="l.replace(/[\s-&]+/g, '-')"
                    data-parent=""
                  >
                    <div class="checkbox-animated mt-0">
                      <label v-if="c.length > 0" class="d-block" :for="l.replace(/[\s-&]+/g, '-') + e">
                        <input
                          :data-main-id="e.replace(/[\s-&]+/g, '-')"
                          class="checkbox_animated select-all"
                          :id="l.replace(/[\s-&]+/g, '-') + e"
                          :data-block-id="l.replace(/[\s-&]+/g, '-')"
                          type="checkbox"
                        /><small class="select inter-normal-jaguar-14px">Select All</small>
                      </label>
                      <div v-for="(n, m) in c" class="checkbox-item-container">
                        <label class="d-block pt-1 pb-1" :for="n.id">
                          <input
                            :data-main-id="e.replace(/[\s-&]+/g, '-')"
                            :class="'checkbox_animated single-checkbox ' + l.replace(/[\s-&]+/g, '-')"
                            :data-block-item-id="l.replace(/[\s-&]+/g, '-')"
                            :id="n.id"
                            :value="n.id"
                            type="checkbox"
                          />
                          <small
                            class="p-1 rounded inter-normal-jaguar-14px"
                            :data-block-text-id="l.replace(/[\s-&]+/g, '-')"
                            >{{ n.checkboxItem }}
                          </small>
                        </label>
                      </div>
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </div>
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script>
export default {
  props: ["records"],
  data() {
    return {
      companyLogo: window.location.origin + "/assets/images/samplelogo3.jpg",
      isActiveMain: null,
      isActiveSub: null,
      filters: [],
    };
  },
  methods: {
    toggleFilterMain(key) {
      if (key == "Asbestos") {
        this.isActiveSub = "tempKeyName";
      }
      this.isActiveMain = this.isActiveMain === key ? null : key;
    },
    toggleFilterSub(key) {
      this.isActiveSub = this.isActiveSub === key ? null : key;
    },
    emitChangeEvent() {
      this.$emit("checkboxChange");
    },
  },
  mounted() {
    $("html, body").css({
      overflow: "auto",
      height: "100%",
    });

    // $(document).on('click', '.toggle-button-main', function(){
    //   let mainKey = $(this).attr('aria-controls')
    //   let mainBody = $('.'+mainKey)
    //   mainBody.each(function () {
    //     // console.log(this)
    //     if ($(this).hasClass('collapsing')) {
    //       $(this).addClass('show')
    //     } else {
    //       $(this).removeClass('collapsing')
    //     }
    //   })
    // })

    const vm = this;

    $(document).on("change", ".single-checkbox", function () {
      let classId = $(this).attr("data-block-item-id");
      let holderId = $(this).attr("data-main-id");
      $("#" + classId + holderId).prop("checked", false);
      let parentId = $(this).parent().parent().parent().parent().attr("id");
      let checkedCounter = 0;

      $(".single-checkbox").each(function () {
        if (this.checked) {
          checkedCounter++;
        }
      });

      let checkBox = $(this).attr("data-main-id");
      if (this.checked) {
        $(this).siblings().addClass("high-light-text");
        $(".filters")
          .find("." + checkBox)
          .addClass("high-light-text");
        $(this).parent().parent().parent().parent().parent().find("button").children().addClass("high-light-text");
      } else {
        $(this).siblings().removeClass("high-light-text");
        if (checkedCounter == 0) {
          $("#" + classId + holderId).prop("checked", false);
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .find("button")
            .children()
            .removeClass("high-light-text p-1");
          $(".filters")
            .find("." + checkBox)
            .removeClass("high-light-text p-1");
        }
      }

      vm.emitChangeEvent()
    });

    $(document).on("change", ".select-all", function () {
      let parentId = $(this).parent().parent().parent().parent().attr("id");
      let checkBox = $(this).attr("data-main-id");
      let checkedCounter = 0;

      console.log("checkBox", checkBox);
      $(".select-all").each(function () {
        if ($(this).is(":checked")) {
          checkedCounter++;
        }
      });

      if (this.checked) {
        $(".filters")
          .find("." + checkBox)
          .addClass("high-light-text");
        $(this).parent().parent().parent().parent().parent().find("button").children().addClass("high-light-text p-1");
        $("." + $(this).attr("data-block-id")).each(function () {
          this.checked = true;
          $(this).siblings().addClass("high-light-text");
        });
      } else {
        if (checkedCounter == 0) {
          $(".filters")
            .find("." + checkBox)
            .removeClass("high-light-text");
        }
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .find("button")
          .children()
          .removeClass("high-light-text p-1");
        $("." + $(this).attr("data-block-id")).each(function () {
          this.checked = false;
          $(this).siblings().removeClass("high-light-text");
        });
      }

      vm.emitChangeEvent()
    });
  },
};
</script>
