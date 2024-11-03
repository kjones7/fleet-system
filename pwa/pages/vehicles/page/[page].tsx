import { GetStaticPaths, GetStaticProps } from "next";
import { dehydrate, QueryClient } from "react-query";

import {
  PageList,
  getVehicles,
  getVehiclesPath,
} from "../../../components/vehicle/PageList";
import { PagedCollection } from "../../../types/collection";
import { Vehicle } from "../../../types/Vehicle";
import { fetch, getCollectionPaths } from "../../../utils/dataAccess";

export const getStaticProps: GetStaticProps = async ({
  params: { page } = {},
}) => {
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(getVehiclesPath(page), getVehicles(page));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<Vehicle>>("/vehicles");
  const paths = await getCollectionPaths(
    response,
    "vehicles",
    "/vehicles/page/[page]"
  );

  return {
    paths,
    fallback: true,
  };
};

export default PageList;
