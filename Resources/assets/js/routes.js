const Account = () => import('^/Account/Resources/assets/components/Account.vue')

export default class routes{
    constructor(Meta) {
        this.meta = Meta;
    }

    route(){
        return [
            {
                path: 'account/profile',
                name: 'account-profile',
                components : {
                    content : Account,
                },
                meta: {...this.meta, title_dashboard: 'Account'}
            },
        ]
    }
}