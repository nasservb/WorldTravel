import * as _ from 'lodash';


export function route(key, params = false) {
    let route = _.find(window.routes, function (r) {
        return r.name === key;
    });

    if (!_.isObjectLike(route)) {
        console.log('Route ' + key + ' not found!');
        return key;
    }

    route = '/' + route.uri;
    if (params) {
        _.forEach(params, (param, index) => {
            route = _.replace(route, '{' + index + '}', param);
        });
    }

    if (window.proxy && window.proxy.length > 0) {
        route = window.proxy + '/' + route;
    }
    return route;
}

export function __(key, params = false) {
    let trans = _.get(window.trans, key, key);

    if (trans.substring(trans.length - 1) !== " ") {
        trans = trans + ' ';
    }

    if (params) {
        _.forEach(params, (param, index) => {
            if (trans.indexOf(':' + index + ' ') > 0) {
                trans = _.replace(trans, ':' + index, param);
            }
        });
    }

    if (trans.substring(trans.length - 1) !== " ") {
        trans = trans.substring(0, trans.length - 1);
    }

    return trans;
}
