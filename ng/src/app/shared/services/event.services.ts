import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {Event} from "./interfaces/event";
import {Status} from "./interfaces/status";

@Injectable()
export class EventServices {
	private eventUrl = "api/event/";

	constructor(protected http: HttpClient) {}

	deleteEvent(eventId: string) : Observable<Status> {
		return(this.http.delete<Status>(this.eventUrl +eventId));
	}

	getAllEvents() : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl));
	}

	getEvent(eventId: string) : Observable<Event> {
		return(this.http.get<Event>(this.eventUrl + eventId));
	}

	createEvent(event: Event) : Observable<Status> {
		return(this.http.post<Event>(this.eventUrl, event));
	}

	editEvent(event: Event) : Observable<Status> {
		return(this.http.put<Status>(this.eventUrl + event.eventId, event));
	}
}