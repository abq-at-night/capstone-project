import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {EventTag} from "../interfaces/eventTag";
import {Status} from "./interfaces/status";

@Injectable()
export class EventTagService {
	private eventTagUrl = "api/eventTag/";

	constructor(protected http: HttpClient) {}

	createEventTag(eventTag: EventTag) : Observable<Status> {
		return(this.http.post<Status>(this.eventTagUrl, eventTag));
	}

	editEventTag(eventTag: EventTag) : Observable<Status> {
		return(this.http.put<Status>(this.eventTagUrl + eventTag.EventTagEventId + eventTag.EventTagTagId, eventTag));
	}
}