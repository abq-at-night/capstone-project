import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "./interfaces/status";

@Injectable()
export class SessionService {

	constructor(protected http:HttpClient) {}

	private sessionUrl = "api/session/";

	setSession() {
		return (this.http.get<Status>(this.sessionUrl, {}));
	}
}