import { NextComponentType, NextPageContext } from "next";
import { useRouter } from "next/router";
import Head from "next/head";
import { useQuery } from "react-query";

import Pagination from "../common/Pagination";
import { List } from "./List";
import { PagedCollection } from "../../types/collection";
import { Vehicle } from "../../types/Vehicle";
import { fetch, FetchResponse, parsePage } from "../../utils/dataAccess";
import { useMercure } from "../../utils/mercure";

export const getVehiclesPath = (page?: string | string[] | undefined) =>
  `/vehicles${typeof page === "string" ? `?page=${page}` : ""}`;
export const getVehicles = (page?: string | string[] | undefined) => async () =>
  await fetch<PagedCollection<Vehicle>>(getVehiclesPath(page));
const getPagePath = (path: string) =>
  `/vehicles/page/${parsePage("vehicles", path)}`;

export const PageList: NextComponentType<NextPageContext> = () => {
  const {
    query: { page },
  } = useRouter();
  const { data: { data: vehicles, hubURL } = { hubURL: null } } = useQuery<
    FetchResponse<PagedCollection<Vehicle>> | undefined
  >(getVehiclesPath(page), getVehicles(page));
  const collection = useMercure(vehicles, hubURL);

  if (!collection || !collection["hydra:member"]) return null;

  return (
    <div>
      <div>
        <Head>
          <title>Vehicle List</title>
        </Head>
      </div>
      <List vehicles={collection["hydra:member"]} />
      <Pagination collection={collection} getPagePath={getPagePath} />
    </div>
  );
};
