import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";
import {Tag} from "../interfaces/tag";
import {Status} from "../interfaces/status";

@Injectable()
export class TagService {

	constructor(protected http: HttpClient) {
	}

	private tagUrl = "api/tag/";

	deleteTag(tagId: string): Observable<Status> {
		return (this.http.delete<Status>(this.tagUrl + tagId));
	}

	getAllTags(): Observable<Tag[]> {
		return (this.http.get<Tag[]>(this.tagUrl));
	}

	getTag(tagId: string): Observable<Tag> {
		return (this.http.get<Tag>(this.tagUrl + tagId));
	}

	createTag(tag: Tag): Observable<Status> {
		return (this.http.post<Status>(this.tagUrl, tag));
	}

	editTag(tag: Tag): Observable<Status> {
		return (this.http.put<Status>(this.tagUrl + tag.tagId, tag));
	}
}