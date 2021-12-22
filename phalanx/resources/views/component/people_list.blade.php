{{--
    【使用方法】
    <!-- モーダルを呼び出す -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="user">
        利用者
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#peopleListModal" data-target-group="staff">
        職員
    </button>

    【情報】
    各種情報はAPIから取得される。
    checkListにチェックされている人のIDが格納される。
    $aTargetUsers(ターゲットのID配列)をviewに渡すとjsのcheckListに渡される。
    .insert-checked-peopleの中に名前一覧が挿入される。
--}}


<!-- Modal -->
<div id="peopleListModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="peopleListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="peopleListModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex flex-column insert-office">
                {{-- jsで動的に追加 --}}
            </div>
            <div class="modal-footer">
                <button id="people-list-modal-ok" type="button" class="btn btn-primary">決定</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
            </div>
        </div>
    </div>
</div>




<script>
    // 画面幅
    var viewportWidth = $(window).width();
    // カラム数
    var peopleColumn = viewportWidth<576 ? 2 : viewportWidth<768 ? 2 : viewportWidth<992 ? 2 : viewportWidth<1200 ? 3 : viewportWidth<1400 ? 5 : 5;
    var oldPeopleColumn = peopleColumn;
    // 1カラムの人数
    var oneColumnNumber = 10;
    // チェックされている人のID
    var aCheckList = @json($aTargetUsers ?? []);
    if('{{ old("is_all_day") }}' != '')     // oldが存在したら(力技)空に
        aCheckList = [];
    if('{{ old("target_users") }}' != '')
        aCheckList = '{{ old("target_users") }}'.split(',').map(Number);
    var aCheckListBuffer;
    // 事業所全員がチェックされているか
    var aIsAllCheck = [];
    // 表示するグループ 利用者、職員
    var targetGroup;
    // ロード状態フラグ
    var fo_completed_load = {
        people: false, office: false,
        ready: function() {
            return this.people && this.office;
        }
    };

    var aOffice = [];
    var myOffice = @json(Auth::user()->office_id);
    var targetUserType;
    var aPeople = [];
    const officeHtml = '\
        <div class="f-office order-[OrderNo]">\n\
            <div class="d-flex justify-content-center" style="position: relative">\n\
                <hr color="black" width="90%" size: 2; align="center">\n\
                <p style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 0 0.6rem;"><a data-toggle="collapse" href="#list-[EnName]" class="collapse-trigger"><i class="fas fa-chevron-down"></i> <b>[Name]</b></a> <input id="[EnName]-all-check" class="all-check" type="checkbox" style="margin: 0 0 0 0.2rem; vertical-align: middle;" data-child-class="[EnName]"></p>\n\
            </div>\n\
            <div id="list-[EnName]" class="collapse people_list">\n\
                <div class="d-flex flex-row justify-content-between mt-1 mb-3 insert-[EnName]">\n\
                </div>\n\
            </div>\n\
        </div>\n\
        ';

    const peopleHtmlNest = '<div class="flex-fill ml-3">';
    const peopleHtml = '<p><label><input type="checkbox" class="[EnName] check-individual" style="vertical-align: middle;" data-people-id="[PeopleId]" data-group="[EnName]"> [PeopleName]</label></p>';
    const ancompleted = '<p><b>読み込み中</b></p>';
    const noChuse = '<p class="text-danger">未選択</p>';


    //-- 読み込まれたタイミングで実行
    $(function(){
        // ajaxの規定値を設定
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //-- APIからメンバー情報を取得
        $.ajax({
            type: "POST",
            url: "/api/v1.0/get/users.json", // 送り先
            data: {},   // 渡したいデータをオブジェクトで渡す
            dataType : "json",  // データ形式を指定
            scriptCharset: 'utf-8'  // 文字コードを指定
        })
        .done( function(param){     // paramに処理後のデータが入って戻ってくる
                aPeople = param; // 帰ってきたら実行する処理
                updateUserList();
                fo_completed_load['people'] = true;
            })
        .fail( function(XMLHttpRequest, textStatus, errorThrown){   // エラーが起きた時はこちらが実行される
                console.log(XMLHttpRequest);    // エラー内容表示
        });

        //-- APIから事業所情報を取得
        $.ajax({
            type: "POST",
            url: "/api/v1.0/get/offices.json",
            data: {},
            dataType : "json",
            scriptCharset: 'utf-8'
        })
        .done( function(param){
                aOffice = param;
                aOffice.push({ id : 0, en_office_name : "experience", office_name : "体験" });
                fo_completed_load['office'] = true;
            })
        .fail( function(XMLHttpRequest, textStatus, errorThrown){
                console.log(XMLHttpRequest);
        });

        //-- 読み込み完了していればモーダル描画 定期的にチェック
        var timer = setInterval(() => {
            if(fo_completed_load.ready()) {
                modalWrite();
                clearInterval(timer);
            }
        }, 500);

        $('#old_target_users').attr('value', aCheckList.join(','));
        $('#target_users').attr('value', aCheckList.join(','));

    });


    //-- モーダルが呼び出されたとき
    $(document).ready(function(){
        $(document).on('show.bs.modal','#peopleListModal', function ( event ) {
            aCheckListBuffer = aCheckList.concat();
            let button = $(event.relatedTarget) //モーダルを呼び出すときに使われたボタンを取得
            let targetGroup = button.data('target-group');

            //職員ボタンから
            if( targetGroup == "staff" ) {
                targetUserType = 1;
                $('#peopleListModalLabel').text('職員一覧');
            }
            //利用者ボタンから
            else if( targetGroup == "user" ) {
                targetUserType = 2;
                $('#peopleListModalLabel').text('利用者一覧');
            }

            modalWrite();
        });
    });

    //-- ウィンドウサイズが変更されたとき
    $(window).resize(function(){
        viewportWidth = $(window).width();
        // 横幅に応じてカラム数変更
        peopleColumn = viewportWidth<576 ? 2 : viewportWidth<768 ? 2 : viewportWidth<992 ? 2 : viewportWidth<1200 ? 3 : viewportWidth<1400 ? 5 : 5;
        if( peopleColumn != oldPeopleColumn ) { 
            oldPeopleColumn = peopleColumn;
            if( ($('#peopleListModal').data('bs.modal') || {})._isShown ) {
                modalWrite();
            }
        }
    });

    //-- 展開・縮小ボタンが押されたとき
    $(document).on('click', '.collapse-trigger', function(){
        let fas = $(this).find(".fas");
        if( fas.hasClass("fa-chevron-down") ) {
            fas.removeClass("fa-chevron-down");
            fas.addClass("fa-chevron-up");
        } else {
            fas.removeClass("fa-chevron-up");
            fas.addClass("fa-chevron-down");
        }
    });

    //-- 全てにチェックがクリックされたとき
    $(document).on('click', '.all-check', function(){
        if ( $(this).prop('checked') == true ) {
            $('.'+$(this).data('child-class')).each(function(index, element){
                $(this).prop('checked', true);
                if( aCheckListBuffer.includes($(this).data('people-id')) == false )
                    aCheckListBuffer.push($(this).data('people-id'));
            });
            aIsAllCheck.push($(this).data('child-class')+'-'+targetUserType);
        } else {
            $('.'+$(this).data('child-class')).each(function(index, element){
                $(this).prop('checked', false);
                aCheckListBuffer.splice(aCheckListBuffer.indexOf($(this).data('people-id')), 1);
            });
            aIsAllCheck.splice(aCheckListBuffer.indexOf($(this).data('child-class')+'-'+targetUserType), 1);
        }
    });

    //-- 個別チェックに変更があった時(全チェック時には発火しないので個別対応)
    $(document).on('change', 'div.people_list input[type=checkbox]', function(){
        if( $(this).prop('checked') ) {
            //増加
            aCheckListBuffer.push($(this).data('people-id'));
        } else {
            //削減
            aCheckListBuffer.splice(aCheckListBuffer.indexOf($(this).data('people-id')), 1);
        }
    });

    //-- 個別チェックがクリックされたとき
    $(document).on('click', 'div.people_list input[type=checkbox]', function(){
        //-- 全チェックになった時と、その逆の動作
        let fAllCheck = true;
        $('.'+$(this).data('group')).each(function(index, element){
            if( element.checked == false ) fAllCheck = false;
        });
        $('#' + $(this).data('group') + '-all-check').prop('checked', fAllCheck);

        //-- 全チェックフラグ操作
        if( fAllCheck )
            aIsAllCheck.push($(this).data('group')+'-'+targetUserType);
        else
            aIsAllCheck.splice(aCheckListBuffer.indexOf($(this).data('group')+'-'+targetUserType), 1);
    });

    //-- 決定ボタンを押したときの動作
    $('#people-list-modal-ok').on('click', function(){
        aCheckList = aCheckListBuffer
        $('#target_users').attr('value', aCheckList.join(','));
        updateUserList();
        $('#peopleListModal').modal('hide');
        
        // console.log(aCheckList);
        // console.log(aIsAllCheck);
    });


    function modalWrite() {
        let insertOffice = $('.insert-office');
        insertOffice.empty();

        //-- 未読み込みのとき
        if( fo_completed_load.ready() == false ) {
            insertOffice.append(ancompleted);
            return;
        }

        $.each(aOffice, function(index, element){
            //-- 各種置換
            let st = officeHtml.replace(/\[EnName\]/g, element.en_office_name);
            st = st.replace(/\[Name\]/g, element.office_name);
            // 自分の事業所を
            if( element.id == myOffice) {
                // 表示順を最上に、初期状態を展開に
                st = st.replace(/\[OrderNo\]/g, "0");
                st = st.replace(/fa-chevron-down/g, "fa-chevron-up");
                st = st.replace(/(?<=class="collapse people_list)(?=")/g, " show");
            }
            else st = st.replace(/\[OrderNo\]/g, index +1);

            insertOffice.append(st);

            let insertPeople = $('.insert-' + element.en_office_name);
            let count = 0, countAll = 0;
            let nest;
            let fAllCheck = true;
            let fNotClose = false;
            let exc_people = aPeople.filter(e => (e.office_id == element.id  &&  e.user_type_id == targetUserType));
            oneColumnNumber = Math.floor(exc_people.length/peopleColumn);
            if( exc_people.length%peopleColumn != 0 ) oneColumnNumber++;

            insertPeople.empty();
            $.each(exc_people, function(index2, element2){
                let cc = count % oneColumnNumber;
                if(cc == 0) {
                    nest = $(peopleHtmlNest);
                    fNotClose = true;
                }
                let st2 = peopleHtml.replace(/\[EnName\]/g, element.en_office_name);
                st2 = st2.replace(/\[PeopleId\]/g, element2.id);
                st2 = st2.replace(/\[PeopleName\]/g, element2.name);
                if( aCheckList.includes(element2.id) ) {
                    st2 = st2.replace(/(?<=<input type="checkbox".*?check-individual[^>]*)(?=>)/g, " checked");
                } else {
                    fAllCheck = false;
                }
                nest.append(st2);

                if(fNotClose) {
                    insertPeople.append(nest);
                    fNotClose = false;
                }
                count++;
                countAll++;
            });

            // 1つ以上項目があって、全てにチェックが付いていたら全チェックをcheckedにする
            if( countAll > 0 )
                $('#' + element.en_office_name + '-all-check').prop('checked', fAllCheck);
        });

        //---- 体験
        if( targetUserType == 1 ) {
            $('.insert-experience').closest('.f-office').remove();
        }
        else if( targetUserType == 2 ) {
            let insertPeople = $('.insert-experience');
            let count = 0, countAll = 0;
            let nest;
            let fAllCheck = true;
            let fNotClose = false;
            let exc_people = aPeople.filter(e => (e.user_type_id == 3));
            oneColumnNumber = Math.floor(exc_people.length/peopleColumn);
            if( exc_people.length%peopleColumn != 0 ) oneColumnNumber++;

            insertPeople.empty();
            $.each(exc_people, function(index2, element2){
                let cc = count % oneColumnNumber;
                if(cc == 0) {
                    nest = $(peopleHtmlNest);
                    fNotClose = true;
                }
                let st2 = peopleHtml.replace(/\[EnName\]/g, 'experience');
                st2 = st2.replace(/\[PeopleId\]/g, element2.id);
                st2 = st2.replace(/\[PeopleName\]/g, element2.name);
                if( aCheckList.includes(element2.id) ) {
                    st2 = st2.replace(/(?<=<input type="checkbox".*?check-individual[^>]*)(?=>)/g, " checked");
                } else {
                    fAllCheck = false;
                }
                nest.append(st2);

                if(fNotClose) {
                    insertPeople.append(nest);
                    fNotClose = false;
                }
                count++;
                countAll++;
            });

            // 1つ以上項目があって、全てにチェックが付いていたら全チェックをcheckedにする
            if( countAll > 0 )
                $('#experience-all-check').prop('checked', fAllCheck);
        }
    }

    function updateUserList() {
        let insert = $('.insert-checked-people');
        let names = [];
        let aCheckListMinus = aCheckList;
        insert.empty();
        //-- idを昇順ソート
        aCheckList.sort(function(a,b){
            if( a < b ) return -1;
            if( a > b ) return 1;
            return 0;
        });
        //------ 事業所全員がチェックされているかチェック
        let oOfficeUserId = {};
        //-- 全体を事業所ごとに分ける
        aPeople.forEach(value => {
            if(value.user_type_id == 1) {
                if(oOfficeUserId[value.office.office_name+' 職員'] == null) oOfficeUserId[value.office.office_name+' 職員']=[];
                oOfficeUserId[value.office.office_name+' 職員'].push(value.id);
            } else if(value.user_type_id == 2) {
                if(oOfficeUserId[value.office.office_name+' 通所者'] == null) oOfficeUserId[value.office.office_name+' 通所者']=[];
                oOfficeUserId[value.office.office_name+' 通所者'].push(value.id);
            } else if(value.user_type_id == 3) {
                if(oOfficeUserId['体験'] == null) oOfficeUserId['体験'] = [];
                oOfficeUserId['体験'].push(value.id);
            }
        });
        //-- 事業所ごとに、全員がいたら表示に +事業所名 -個人名
        Object.keys(oOfficeUserId).forEach(key => {
            if(oOfficeUserId[key].filter(e => !aCheckList.includes(e)).length == 0) {
                names.push('【'+key+'】');
                aCheckListMinus = aCheckListMinus.filter( e => {
                    return !oOfficeUserId[key].includes(e);
                });
            }
        });

        if(aCheckList.length == 0) {
            insert.append(noChuse);
            return;
        }

        st = '<span>';
        $.each(names, (index, element) => {
            st += element;
        });
        $.each(aCheckListMinus, (index, element) => {
            if(index >= 20) {
                st += ' ...他'+ String(aCheckListMinus.length-index) +'名';
                return false;
            }
            st += aPeople.find( (elem) => elem.id == element).name + '/ ';
        });
        st += '</span>';
        insert.append(st);
    }

</script>
