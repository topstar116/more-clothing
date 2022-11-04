<template>
    <div class="image-upload">
        <!-- モーダル -->
        <div id="modal-delete-image" uk-modal uk-toggle="target: #modal-update">
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-default" type="button" uk-toggle="target: #modal-update"></button>
                <div class="uk-modal-body">
                    <h2 class="uk-modal-title">荷物の画像を削除</h2>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="c-button c-button--default u-mr10" type="button" uk-toggle="target: #modal-update">キャンセル</button>
                    <!-- <button class="c-button c-button--bgPink" @click="deleteFile(index, courseDate[index] ? courseDate[index]['id'] : '')">画像を削除</button> -->
                    <button class="c-button c-button--bgPink" @click="deleteFile(deleteIndex, deleteNumber)">画像を削除</button>
                </div>
            </div>
        </div>

        <!-- 本文 -->
        <div class="image-upload-input">
            <ul class="upload-detail-img u-pl0">
                <li class="upload-detail-img-inner" v-for="(item, index) in couseDetailFiles" :key="item.id">
                    <!-- 本文 -->
                    <div class="item__img u-w100per">
                        <div class="item__img__inner c-img--cover">
                            <img :src="item.url" v-if="item.url !== ''">
                            <span
                                class="delete-file pc-only"
                                :class="{active: item.isDelete}"
                                type="button"
                                uk-toggle="target: #modal-delete-image"
                                @click="setDelete(index, courseDate[index] ? courseDate[index]['id'] : '')"
                            >
                            </span>
                            <span class="add-file" :class="{active: item.isAdd}">
                                <input
                                    type="file"
                                    accept="image/*"
                                    :name="'img' + (index + 1)"
                                    :id="'img' + (index + 1)"
                                    :ref="'file' + index"
                                    @change="uploadFile(index)"
                                >
                            </span>
                        </div>
                    </div>
                    <span class="change-file" :class="{active: item.isChange}">
                        <span class="change-file-inner">
                            <button @click.prevent="changeFile(index, courseDate[index] ? courseDate[index]['id'] : '')">
                                <img src="/img/icon-camera-black.png">
                            </button>
                        </span>
                    </span>
                    <!-- <span class="delete-icon sp-only" :class="{active: item.isDelete}" @click="deleteFile(index)"> -->
                    <span class="delete-icon sp-only" :class="{active: item.isDelete}" type="button" uk-toggle="target: #modal-delete-image" @click="setDelete()">
                        <img src="/img/icon-dust-black.png">
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    var old_id = '';
    import axios from 'axios'

	export default {
        components: {},
        props: ['course'],
        data() {
            return {
                courseDate: this.course ?? '',
				couseDetailFiles: [
					{ id: 0, itemId: "", url: "", isAdd: true, isDelete: false, isChange: false },
					{ id: 1, itemId: "", url: "", isAdd: false, isDelete: false, isChange: false },
					{ id: 2, itemId: "", url: "", isAdd: false, isDelete: false, isChange: false },
					{ id: 3, itemId: "", url: "", isAdd: false, isDelete: false, isChange: false },
					{ id: 4, itemId: "", url: "", isAdd: false, isDelete: false, isChange: false },
                ],
                // 荷物画像削除用のデータ
                deleteIndex: 0,
                deleteNumber: 0,
                // validationNumber: 100,
            }
        },
        created: function() {
            // 画像の初期設定
            if(this.courseDate[0]) {
                // this.$refs['file0'].files[0] = this.courseDate[0].url;
                this.couseDetailFiles[0].url = this.courseDate[0].image_url;
                this.couseDetailFiles[0].itemId = this.courseDate[0].id;
                this.couseDetailFiles[0].isAdd = false;
                this.couseDetailFiles[0].isDelete = false;
                this.couseDetailFiles[0].isChange = true;
                this.couseDetailFiles[1].isAdd = true
                this.couseDetailFiles[1].isDelete = false;
            }
            if(this.courseDate[1]) {
                this.couseDetailFiles[1].url = this.courseDate[1].image_url;
                this.couseDetailFiles[1].itemId = this.courseDate[1].id;
                this.couseDetailFiles[1].isAdd = false;
                this.couseDetailFiles[1].isDelete = true;
                this.couseDetailFiles[1].isChange = true;
                this.couseDetailFiles[2].isAdd = true;
                this.couseDetailFiles[2].isDelete = false;
            }
            if(this.courseDate[2]) {
                this.couseDetailFiles[2].url = this.courseDate[2].image_url;
                this.couseDetailFiles[2].itemId = this.courseDate[2].id;
                this.couseDetailFiles[2].isAdd = false;
                this.couseDetailFiles[2].isDelete = true;
                this.couseDetailFiles[2].isChange = true;
                this.couseDetailFiles[3].isAdd = true;
                this.couseDetailFiles[3].isDelete = false;
            }
            if(this.courseDate[3]) {
                this.couseDetailFiles[3].url = this.courseDate[3].image_url;
                this.couseDetailFiles[3].itemId = this.courseDate[3].id;
                this.couseDetailFiles[3].isAdd = false;
                this.couseDetailFiles[3].isDelete = true;
                this.couseDetailFiles[3].isChange = true;
                this.couseDetailFiles[4].isAdd = true;
                this.couseDetailFiles[4].isDelete = false;
            }
            if(this.courseDate[4]) {
                this.couseDetailFiles[4].url = this.courseDate[4].image_url;
                this.couseDetailFiles[4].itemId = this.courseDate[4].id;
                this.couseDetailFiles[4].isAdd = false;
                this.couseDetailFiles[4].isDelete = true;
                this.couseDetailFiles[4].isChange = true;
            }
        },
        mounted: function () {
        },
        watch: {},
        computed: {
        },
        methods: {
            // 画像のアップロード
			uploadFile: function(index) {
                console.log('upload file')
                const files = this.$refs['file' + index]
                const fileImg = files[0].files[0]
                console.log(fileImg);
                // // ファイルを取得する
                if (fileImg.size > 10485760) {
                    alert('ファイルの上限サイズ10MBを超えています')
                } else {
                    
                    const target = this.couseDetailFiles
                    if (fileImg.type.startsWith("image/")) {
                        target[index].isAdd = false
                        target[index].isChange = true
                        target[index].url = window.URL.createObjectURL(fileImg)
                        if (index < 4 && target[index+1].url == "" && target[index+1].isAdd == false) {
                            // 次の画像アップロード箇所追加
                            target[index+1].isAdd = true;
                        }
                        if(!index == 0) {
                            target[index].isDelete = true
                        }
                    }
                    // バリデーション用
                    this.validationNumber += 1
                    this.$emit('add')
                }
                
			},
			// 画像の変更
			changeFile: function(index, id) {
                this.$refs['file' + index][0].click();
                console.log(id);
                old_id = id;
			},
            // 画像の削除用のデータを登録
            setDelete: function(index, id) {
                this.deleteIndex = index;
                this.deleteNumber = id;
            },
            // 画像の削除
			deleteFile: function(index, id) {
                console.log(id);
                const target = this.couseDetailFiles
                target[index].url = ""
                this.$refs['file' + index][0].value = ""

                // params設定
                const params = {
                    image_id : id,
                }

                // 画像を削除
                axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                console.log(axios.defaults.headers.common)
                axios.delete('/admin/item-image/delete/'+id)
                .then(result => {
                    console.log('削除が成功しました。');
                })
                .catch(result => {
                    console.log('削除が失敗しました。');
                })
                
                // 初期設定の画像を削除
                // document.getElementsByClassName('item-image-' + index).remove();
                // console.log(initialItemImage);q
    
                // クリックした画像が最後の場合
                if(index == 4) {
                    target[index].url = ""
                    target[index].itemId = ""
                    target[index].isAdd = true
                    target[index].isChange = false
                    target[index].isDelete = false
                } else {
                    // クリックした画像が最後以外の場合
                    // クリックした画像の次の画像がない場合
                    if(target[index+1].isAdd == true) {
                        target[index].url = ""
                        target[index].itemId = ""
                        target[index].isAdd = true
                        target[index].isChange = false
                        target[index].isDelete = false
                        target[index+1].isAdd = false
                    } else {
                        // クリックした画像の次に画像がある場合
                        let t = 0;
                        for(t; t < 5; t++) {
                            if(target[index + t + 1]) {
                                target[index + t].url = target[index + t + 1].url
                                target[index + t].itemId = target[index + t + 1].itemId
                                if( target[index + t + 1].isAdd == true ) break;
                            } else {
                                break
                            }
                        }
                        target[index+t].url = ""
                        target[index+t].itemId = ""
                        target[index+t].isAdd = true
                        target[index+t].isChange = false
                        target[index+t].isDelete = false
                        if(target[index+t+1].isAdd == true) {
                            target[index+t+1].isAdd = false
                        }
                    }
                }
                this.validationNumber -= 1
                this.$emit('remove');
            }
        },
    }
</script>
