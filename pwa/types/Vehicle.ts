import { Item } from "./item";

export class Vehicle implements Item {
  public "@id"?: string;

  constructor(_id?: string) {
    this["@id"] = _id;
  }
}
