import route from 'gird-base-front/src/plugins/utils/endpoint/route'
import {BaseEndpoints}  from 'gird-base-front/src/plugins/utils/endpoint/endpoints'
import {Endpoints} from './endpoints'

BaseEndpoints.routes = Object.assign(BaseEndpoints.routes, Endpoints.routes);

export default  (name, params, absolute) =>  route(name, params, absolute, BaseEndpoints);
